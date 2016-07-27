<?php

namespace Magnus;

use Carbon\Carbon;
use Magnus\Helpers\Images;
use Magnus\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image_path', 'thumbnail_path', 'preview_path',
        'title', 'comment', 'user_id', 'daily_views',
        'published_at', 'views', 'slug', 'directory'
    ];

    protected $dates = ['published_at','created_at','deleted_at'];
    protected $resizeTo = 250;
    protected $resizeExtension = 'jpg';

    /**
     * Opus has a M:1 relationship with User model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Magnus\User');
    }

    /**
     * Opus has a 0:M relationship with Comment model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->morphMany('Magnus\Comment', 'commentable');
    }

    /**
     * Opus model has an M:N relationship with Tag model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('Magnus\Tag')->withTimestamps();
    }

    /**
     * Opus model has a M:N relationship with Gallery model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function galleries()
    {
        return $this->belongsToMany('Magnus\Gallery')->withTimestamps();
    }

    /**
     * Opus model has a 1:M relationship with Notification model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('Magnus\Notification');
    }

    /**
     * An belongs to one favorite model that is shared by all users who
     * have added the opus to their favorites
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function favorite()
    {
        return $this->hasOne('Magnus\Favorite');
    }

    /**
     * An opus can have many categories
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('Magnus\Category', 'category_opus')->withTimestamps();
    }

    /**
     * get a list of tag ids associated with the current piece
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->lists('id');
    }

    /**
     * Set the user_id attribute of this opus
     * @param $id
     */
    public function setUserIdAttribute($id)
    {
        $this->attributes['user_id'] = $id;
    }

    /**
     * Query scope that only returns Opus that are published
     * @param $query
     */
    public function scopePublished($query)
    {
        $query->where('opuses.published_at', '<=', Carbon::now());
    }

    /**
     * Query scope that only returns Opus that are unpublished
     * @param $query
     */
    public function scopeUnpublished($query)
    {
        $query->where('opuses.published_at', '=>', Carbon::now());
    }

    /**
     * Query scope opus created $time hours ago
     * @param $query
     * @param int $time
     */
    public function scopeHoursAgo($query, $time = 24)
    {
        $hoursAgo = new Carbon("-$time hours");
        $query->whereDate('opuses.created_at', '>', $hoursAgo->toDateString());
    }

    /**
     * Query scope opus created today
     * @param $query
     */
    public function scopeToday($query)
    {
        $query->whereDate('opuses.created_at', '>', Carbon::yesterday()->toDateString());
    }

    /**
     * Query scope for opus created $days ago
     * @param $query
     * @param int $days
     * @return mixed
     */
    public function scopeDaysAgo($query, $days = 3)
    {
        $daysAgo = new Carbon("-$days days");
        return $query->whereDate('opuses.created_at', '>', $daysAgo->toDateString());
    }

    /**
     * Query scope for sorting by page views
     * @param $query
     */
    public function scopePopular($query)
    {
        $query->orderBy('opuses.views', 'desc');
    }

    /**
     * Query scope for sorting by newest first
     * @param $query
     */
    public function scopeNewest($query)
    {
        $query->orderBy('opuses.created_at', 'desc');
    }

    /**
     * A scope for sorting by daily views descending
     * @param $query
     */
    public function scopeTrending($query)
    {
        $query->orderBy('opuses.daily_views', 'desc');
    }

    /**
     * Setter for published_at attribute
     * @param $date
     */
    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::parse($date);
    }

    /**
     * Return the time of creation with respect to the user's timezone
     * @param $value
     * @return bool|string|static
     */
    public function getCreatedAtAttribute($value)
    {
        if (isset(Auth::user()->timezone)) {
            return Carbon::parse($value)->timezone(Auth::user()->timezone)->format('M d, Y g:i A');
        } else {
            return Carbon::parse($value)->format('F d, Y');
        }
    }

    /**
     *  returns published_at with respect to the user's timezone
     * @param $value
     * @return bool|string
     */
    public function getPublishedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y');
    }
    
    /**
     * Set the slug of the opus
     */
    public function setSlug($setTo = null)
    {
        if (!isset($setTo)) {
            $slug = substr(microtime(), 15).'-'.str_slug($this->title);
        } else {
            $slug = substr(microtime(), 15).'-'.str_slug($setTo);
        }
        $this->slug = $slug;
        return $this;
    }

    /**
     * Returns a relative path to this opus' image
     * @return string
     */
    public function getImage()
    {
        if (!empty($this->image_path) and File::exists($this->image_path)) {
            return  '/'.$this->image_path;
        }
        return $this->imageDirectory.'/images/missing/missing.png';
    }

    public function getFilePath()
    {
        return $this->image_path;
    }

    /**
     * Returns a relative path to this opus' image
     * @return string
     */
    public function getPreview()
    {
        if (!empty($this->preview_path) and File::exists($this->preview_path)) {
            return  '/'.$this->preview_path;
        }
        return $this->imageDirectory.'/images/missing/missing.png';
    }

    /**
     * Returns the relative path to this opus' thumbnail image
     * @return string
     */
    public function getThumbnail()
    {
        if (!empty($this->thumbnail_path) and File::exists($this->thumbnail_path)) {
            return '/'.$this->thumbnail_path;
        }
        return $this->imageDirectory.'/missing/missing-thumb.png';
    }

    /**
     * Static make function to replace the logic in the Opus controller
     * @param Request $request
     * @param User $user
     * @return bool
     */
    public static function make(Request $request, User $user)
    {
        $opus = new Opus($request->all());
        $opus->published_at = Carbon::now();
        $opus = $user->opera()->save($opus);
        $opus->setSlug()
             ->setDirectory($user)
             ->initViews()
             ->setImage($user, $request)
             ->setPreview($user, $request)
             ->setThumbnail($user, $request)->save();
        $opus->favorite()->save(new Favorite(['opus_id' => $opus->id]));
        return $opus;
    }

//    /**
//     * Resize the opus' image for it's thumbnail or preview
//     * @param $image
//     * @return Image
//     */
//    private function resize($image, $size = null)
//    {
//        $resize = Image::make($image);
//        $newRes = isset($size) ? $size : $this->resizeTo;
//        $ratio = $resize->width() / $resize->height();
//
//        if ($ratio > 1) { // image is wider than tall
//            $resize->resize($newRes, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//        } else { // image is taller than wide
//            $resize->resize(null, $newRes, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//        }
//        return $resize;
//    }

    /**
     * Returns the username and created_at year and current year
     * @return string
     */
    public function published()
    {
        $now = date_format(Carbon::now(), 'Y');
        if($this->published_at != $now)
        {
            return "&copy; " . $this->published_at . " - " . $now . " " . $this->user->username;
        } else {
            return "&copy; " . $this->published_at . " " .$this->user->username;
        }
    }

    protected function initViews()
    {
        $this->views = 0;
        $this->daily_views = 0;

        return $this;
    }
    
//    /**
//     * Handle the uploaded file, rename the file, move the file, return the filepath as a string
//     * @param  \Illuminate\Http\Request  $request
//     * @return string
//     */
//    protected function storeImage(User $user, $request)
//    {
//        $originalFileName = $request->file('image')->getClientOriginalName();
//        $fileName = $user->username.'-'.date('Ymd') . substr(microtime(), 2, 8).'-'.$originalFileName; // renaming image
//        $request->file('image')->move($this->directory, $fileName); // uploading file to given path
//        $fullPath = $this->directory."/".$fileName; // set the image field to the full path
//        return $fullPath;
//    }
//
//    /**
//     * Handle the uploaded file for the opus' preview image
//     * @param  \Illuminate\Http\Request  $request
//     * @return string
//     */
//    protected function storePreview(User $user, $request)
//    {
//        $previewSize = $request->has('resizeTo') ? $request->input('resizeTo') : 680;
//        $fileName = $user->username.'-'.date('Ymd') .'-'. substr(microtime(), 2, 8).'-p.'. $this->resizeExtension; // renaming image
//        $thumbnail = $this->resize($this->getFilePath(), $previewSize);
//        $fullPath = $this->directory."/".$fileName;
//        $thumbnail->save($fullPath);
//        return $fullPath;
//    }
//
//    /**
//     *  Using the uploaded file, create a thumbnail and save it into the thumbnail folder
//     * @param User $user
//     * @param $request
//     * @return string
//     */
//    protected function storeThumbnail(User $user, $request)
//    {
//        $fileName = $user->username.'-'.date('Ymd') .'-'. substr(microtime(), 12, 8).'-t.'. $this->resizeExtension; // renaming image
//        $thumbnail = $this->resize($this->getFilePath());
//        $fullPath = $this->directory."/".$fileName;
//        $thumbnail->save($fullPath);
//        return $fullPath;
//    }

    /**
     * Saves the fullpath of the directory created for the opus
     * @param $directory
     */
    protected function setDirectory($user)
    {
        $this->directory = $this->makeDirectory($user);

        return $this;
    }

    /**
     * Using storeImage(), assign this articles' image attr to the path returned
     * @param User $user
     * @param $request
     * @return $this
     */
    protected function setImage(User $user, $request)
    {
        $this->image_path = Images::storeImage($user, $this, $request);
        //$this->image_path = $this->storeImage($user, $request);
        return $this;
    }

    /**
     * assign this article's thumbnail attribute the path returned
     * @param User $user
     * @param $request
     */
    protected function setThumbnail(User $user, $request)
    {
        //$this->thumbnail_path = $this->storeThumbnail($user, $request);
        $this->thumbnail_path = Images::storeThumbnail($user, $this);
        return $this;
    }

    /**
     * Store the opus preview image
     * @param User $user
     * @param $request
     */
    protected function setPreview(User $user, $request)
    {
        //$this->preview_path = $this->storePreview($user, $request);
        $this->preview_path = Images::storePreview($user, $this, $request);
        return $this;
    }

    /**
     * delete the thumbnail, preview and image for this piece
     * @return bool
     */
    public function deleteImages()
    {
        $path = public_path();
        File::delete($path.'/'.$this->image_path);
        File::delete($path.'/'.$this->thumbnail_path);
        File::delete($path.'/'.$this->preview_path);
        if (!File::exists($path.'/'.$this->image_path)
            and !File::exists($path.'/'.$this->preview_path)
            and !File::exists($path.'/'.$this->thumbnail_path)) {
            return true;
        }
        return false;
    }

    /**
     * Delete's this Opus' images and directory
     * @return void
     */
    public function deleteDirectory()
    {
        $this->deleteImages();
        File::deleteDirectory($this->directory);
    }

    /**
     * Update this piece's image with the new uploaded file
     * @param $request
     * @return string
     */
    public function updateImage(User $user, $request)
    {
        if ($request->file('image') !== null) {  /// check if an image is attached
            $deleted = $this->deleteImages();
            if ($deleted) {
                if ($this->directory == null) {
                    $this->setDirectory($user);
                }
                $this->setImage($user, $request)->setPreview($user, $request)->setThumbnail($user, $request)->update();
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     *  Return an array of tagnames as a string
     * @return string
     */
    public function stringifyTags()
    {
        if ($this->tags->count() > 0) {
            return implode(' ', array_pluck($this->tags->toArray(), 'name'));
        } else {
            return null;
        }
    }

    /**
     * Return an array containing some metadata about the image
     * @return array
     */
    public function metadata()
    {

        try {
            $img = Image::make(public_path().$this->getImage());
            $preview = Image::make(public_path().$this->getPreview());
            $size = ceil($img->fileSize() / 1000);
        } catch (\Exception $e) {
            return ['filesize' => '?' . ' KB', 'resolution' => '?' . 'x' . '?'];
        }
        return ['filesize' => $size . ' KB', 'resolution' => $img->width() . 'x' . $img->height(),
            'width' => $img->width(),
            'height' => $img->height(),
            'previewHeight' => $preview->height()];
    }

    /**
     * Makes a new directory for the opus
     * @param User $user
     * @return string
     */
    protected function makeDirectory(User $user)
    {
        $dirName = 'art/'.strtolower($user->username).'/'.substr(microtime(), 11);
        File::makeDirectory(public_path($dirName), 0755);
        return $dirName;
    }


    /**
     * Determines if the opus already has a tag
     * @param Tag $newTag
     * @return bool
     */
    public function hasTag(Tag $newTag)
    {
        if ($this->tags->count() > 0) {
            foreach ($this->tags as $tag) {
                if ($tag->id == $newTag->id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Increment the pageview of this Opus if conditions are met
     * Opus IDs are stored in sessions
     *
     * The page view is only incremented if the person viewing it is not the owner
     * and the Opus ID is not in the array held in the Session
     * @param $request
     */
    public function pageview($request)
    {
        if (Auth::check() and !Auth::user()->isOwner($this)) {
            $this->viewOpus($request);
        } else {
            $this->viewOpus($request);
        }
    }

    /**
     * Increment's the opus pageview by one
     * @param $request
     */
    private function _viewOpus($request)
    {
        $request->session()->push('viewed', $this->id);
        $this->views = $this->views + 1;
        $this->daily_views = $this->daily_views + 1;
        $this->save();
    }

    /**
     * Determines if the opus id is  in the session, if not
     * increment the page view by one
     * @param $request
     */
    private function viewOpus($request)
    {
        $seen = false;
        $viewed = session('viewed');
        if ($request->session()->has('viewed')) { // check to see if viewed has been set
            foreach ($viewed as $view) {
                if ($this->id == $view) { // the user has seen it before
                    $seen = true;
                    break;
                }
            }
            if (!$seen) {
                $this->_viewOpus($request);
            }
        } else {
            $this->_viewOpus($request);
        }
    }
}
