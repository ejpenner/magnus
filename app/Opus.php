<?php
namespace Magnus;

use Magnus\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class Opus extends Model
{
    protected $fillable = [
        'image_path', 'thumbnail_path',
        'title', 'comment', 'user_id',
        'published_at', 'views', 'daily_views',
        'slug'
    ];

    protected $dates = ['published_at'];
    private $imageDirectory = 'images';
    private $thumbnailDirectory = 'thumbnails';
    private $artDirectory = 'art';
    private $resizeTo = 250;

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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany('Magnus\Comment');
    }

    /**
     * Opus model has an M:N relationship with Tag model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('Magnus\Tag')->withTimestamps();
    }

    /**
     * Opus model has a M:N relationship with Gallery model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function galleries() {
        return $this->belongsToMany('Magnus\Gallery')->withTimestamps();
    }

    /**
     * Opus model has a 1:M relationship with Notification model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications() {
        return $this->hasMany('Magnus\Notification');
    }

    /**
     * get a list of tag ids associated with the current piece
     *
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->lists('id');
    }

    /**
     * Set the user_id attribute of this opus
     *
     * @param $id
     */
    public function setUserIdAttribute($id)
    {
        $this->attributes['user_id'] = $id;
    }

    /**
     * Query scope that only returns Opus that are published
     *
     * @param $query
     */
    public function scopePublished($query) {
        $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * Query scope that only returns Opus that are unpublished
     *
     * @param $query
     */
    public function scopeUnpublished($query)
    {
        $query->where('published_at', '=>', Carbon::now());
    }

    public function scopeHoursAgo($query, $time = 24)
    {
        $hoursAgo = new Carbon("-$time hours");
        $query->whereDate('created_at', '>', $hoursAgo->toDateString());
    }

    public function scopeToday($query)
    {
        $query->whereDate('created_at', '>', Carbon::yesterday()->toDateString());
    }

    public function scopeDays($query, $days = 3)
    {
        $daysAgo = new Carbon("-$days days");
        return $query->whereDate('created_at', '>', $daysAgo->toDateString());
    }

    public function scopePopular($query)
    {
        $query->orderBy('views', 'desc');
    }
    
    public function scopeNewest($query)
    {
        $query->orderBy('created_at', 'desc');
    }

    public function scopeViews($query)
    {
        $query->orderBy('views', 'desc');
    }

    /**
     * Setter for published_at attribute
     * @param $date
     */
    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::parse($date);
        //$this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
     * Return the time of creation with respect to the user's timezone
     * @param $value
     * @return bool|string|static
     */
    public function getCreatedAtAttribute($value) {
        if(isset(Auth::user()->timezone)) {
            return date_format(Carbon::parse($value)->timezone(Auth::user()->timezone), 'M d, Y g:iA');
        } else {
            return date_format(Carbon::parse($value), 'F d, Y');
        }
    }

    /**
     *  returns published_at with respect to the user's timezone
     *
     * @param $value
     * @return bool|string
     */
    public function getPublishedAtAttribute($value){
        if(isset(Auth::user()->timezone)) {
            return date_format(Carbon::parse($value)->timezone(Auth::user()->timezone), 'F d, Y');
        } else {
            return date_format(Carbon::parse($value), 'F d, Y');
        }
    }

    /**
     * Increment the pageview of this Opus if conditions are met
     * 
     * @param $request
     */
    public function pageview($request) {
        $seen = false;
        $viewed = session('viewed');
        if(Auth::check() and  !Auth::user()->isOwner($this)) {
            if($request->session()->has('viewed')) { // check to see if viewed has been set
                foreach ($viewed as $view) {
                    if ($this->id == $view) { // the user has seen it before
                        $seen = true;
                        break;
                    }
                }
                if (!$seen) {
                    $request->session()->push('viewed', $this->id);
                    $this->daily_views = $this->daily_views + 1;
                    $this->views = $this->views + 1;
                    $this->save();
                }
            } else {
                $request->session()->push('viewed', $this->id);
                $this->daily_views = $this->daily_views + 1;
                $this->views = $this->views + 1;
                $this->save();
            }
        } else { // viewer is a guest
            if($request->session()->has('viewed')) { // guest has seen another opus already
                foreach ($viewed as $view) {
                    if ($this->id == $view) { // the user has seen it before
                        $seen = true;
                        break;
                    }
                }
                if (!$seen) {
                    $request->session()->push('viewed', $this->id);
                    $this->views = $this->views + 1;
                    $this->daily_views = $this->daily_views + 1;
                    $this->save();
                }
            } else { // guest is viewing their first opus
                $request->session()->push('viewed', $this->id);
                $this->daily_views = $this->daily_views + 1;
                $this->views = $this->views + 1;
                $this->save();
            }
        }
    }

    /**
     * Returns a relative path to this opus' image
     *
     * @return string
     */
    public function getImage()
    {
        if (!empty($this->image_path) and File::exists($this->image_path)) {  // $exists = Storage::disk('images')->has(basename($this->image_path));
            return  $this->image_path;
        }
        return $this->imageDirectory.'/images/missing/missing.png';
    }
    /**
     * Returns the relative path to this opus' thumbnail image
     *
     * @return string
     */
    public function getThumbnail()
    {
        if (!empty($this->thumbnail_path) and File::exists($this->thumbnail_path)) {
            return $this->thumbnail_path;
        }
        return $this->imageDirectory.'/missing/missing-thumb.png';
    }

    /**
     * Resize the opus' image for it's thumbnail
     *
     * @param $image
     * @return Image
     */
    private function resize($image, $size = null)
    {
        $resize = Image::make($image);

        $ratio = $resize->width() / $resize->height();

        if($ratio > 1){ // image is wider than tall
            $resize->resize(isset($size) ? $size : $this->resizeTo, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else { // image is taller than wide
            $resize->resize(null, isset($size) ? $size : $this->resizeTo, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        return $resize;
    }

    /**
     * Handle the uploaded file, rename the file, move the file, return the filepath as a string
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function storeImage(User $user, $request)
    {
        $userDirectory = strtolower($user->username);
        //$destinationPath = $this->imageDirectory.'/'.$userDirectory; // upload path, goes to the public folder
        $destinationPath = $this->artDirectory.'/'.$userDirectory.'/'.$this->imageDirectory;
        $originalFileName = $request->file('image')->getClientOriginalName();
        $fileName = $user->username.'-'.date('Ymd') . substr(microtime(), 2, 8).'-'.$originalFileName; // renaming image
        $request->file('image')->move($destinationPath, $fileName); // uploading file to given path
        $fullPath = $destinationPath."/".$fileName; // set the image field to the full path
        return $fullPath;
    }

    /**
     * Handle the uploaded file, rename the file, move the file, return the filepath as a string
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function storeImageV2(User $user, $request, $newDirectory)
    {
        $userDirectory = strtolower($user->username);
        //$destinationPath = $this->imageDirectory.'/'.$userDirectory; // upload path, goes to the public folder
        $destinationPath = $newDirectory;
        $originalFileName = $request->file('image')->getClientOriginalName();
        $fileName = $user->username.'-'.date('Ymd') . substr(microtime(), 2, 8).'-'.$originalFileName; // renaming image
        $request->file('image')->move($destinationPath, $fileName); // uploading file to given path
        $fullPath = $destinationPath."/".$fileName; // set the image field to the full path
        return $fullPath;
    }

    /**
     * Using the uploaded file, create a thumbnail and save it into the thumbnail folder
     *
     * @param $request
     * @return string
     */
    public function storeThumbnail(User $user, $request)
    {
        $userDirectory = strtolower($user->username);
        $thumbDestination = $this->artDirectory.'/'.$userDirectory.'/'.$this->thumbnailDirectory;
        $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
        //$originalFileName = $request->file('image')->getClientOriginalName();
        $fileName = $user->username.'-'.date('Ymd') . substr(microtime(), 2, 8).'-t.'. $extension; // renaming image
        $thumbnail = $this->resize($this->getImage());
        $fullPath = $thumbDestination."/".$fileName;
        $thumbnail->save($fullPath);
        return $fullPath;
    }

    /**
     * Using storeImage(), assign this articles' image attr to the path returned
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function setImage(User $user, $request)
    {
        $this->image_path = $this->storeImage($user, $request);
        $this->save();
    }

    /**
     *  using storeThumbnail(), also assign this article's thumbnail attribute the path returned
     *
     * @param $request
     */
    public function setThumbnail(User $user, $request)
    {
        $this->thumbnail_path = $this->storeThumbnail($user, $request);
        $this->save();
    }

    /**
     * delete the thumbnail and image for this piece
     *
     * @return bool
     */
    public function deleteImages()
    {
        $path = public_path();
        if (File::delete($path.'/'.$this->image_path) && File::delete($path.'/'.$this->thumbnail_path)) {
            return true;
        }
        return false;
    }

    /**
     * Update this piece's image with the new uploaded file
     *
     * @param $request
     * @return string
     */
    public function updateImage(User $user, $request)
    {
        if ($request->file('image') !== null) {  /// check if an image is attached
            if ($this->deleteImages()) {
                $this->setImage($user, $request); // update the image
                $this->setThumbnail($user, $request); // update the thumbnail
                $this->update(); // set the image update
                return 'Image files updated successfully.';
            } else {
                return 'Image files deletion failed.';
            }
        }
        return ' Something went wrong...';
    }

    /**
     *  Return an array of tagnames as a string
     *
     * @return string
     */
    public function stringifyTags() {
        return implode(' ', array_pluck($this->tags->toArray(), 'name'));
    }

    /**
     * Return an array containing some metadata about the image
     *
     * @return array
     */
    public function metadata() {
            try {
                $img = Image::make($this->getImage());
                $size = ceil($img->fileSize() / 1000);
            } catch (\Exception $e) {
                return ['filesize' => '?' . ' KB', 'resolution' => '?' . 'x' . '?'];
            }
            return ['filesize' => $size . ' KB', 'resolution' => $img->width() . 'x' . $img->height()];
    }

    private function makeDirectory(User $user)
    {
        $dirName = 'art/'.$user->username.'/'.substr(microtime(),11);
        File::makeDirectory(public_path($dirName), 4664, true);
        return $dirName;
    }

    public function setSlug()
    {
        $this->slug = substr(microtime(),13).'-'.str_slug($this->title);
        $this->save();
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
        //$opusDirectory = self::makeDirectory($user);
        $opus->setImage($user, $request);
        $opus->setThumbnail($user, $request);
        $opus->setSlug();

        return $opus;
    }
}