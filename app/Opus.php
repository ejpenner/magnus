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
        'title','comment','user_id',
        'published_at', 'views', 'daily_views',
        'slug'
    ];

    protected $dates = ['published_at'];

    private $imageDirectory = 'images';
    private $thumbnailDirectory = 'thumbnails';
    private $usersDirectory = 'usr';
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
            if($request->session()->has('viewed')) {
                foreach ($viewed as $view) {
                    if ($this->id == $view) { // the user has seen it before
                        $seen = true;
                        break;
                    }
                }
                if (!$seen) {
                    $request->session()->push('viewed', $this->id);
                    $this->views = $this->views + 1;
                    $this->save();
                }
            } else {
                $request->session()->push('viewed', $this->id);
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
                    $this->save();
                }
            } else { // guest is viewing their first opus
                $request->session()->push('viewed', $this->id);
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
        if (!empty($this->image_path) && File::exists($this->image_path)) {  // $exists = Storage::disk('images')->has(basename($this->image_path));
            // Get the filename from the full path
            //$filename = basename($this->image_path);
            return  $this->image_path;
        }
        return $this->imageDirectory.'/missing.png';
    }
    /**
     * Returns the relative path to this opus' thumbnail image
     *
     * @return string
     */
    public function getThumbnail()
    {
        if (!empty($this->thumbnail_path) && File::exists($this->thumbnail_path)) {
            // Get the filename from the full path
            //$filename = basename($this->thumbnail_path);
            return $this->thumbnail_path;
        }
        return $this->imageDirectory.'/missing-thumb.png';
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
        $userDirectory = $user->username;
        //$destinationPath = $this->imageDirectory.'/'.$userDirectory; // upload path, goes to the public folder
        $destinationPath = $this->usersDirectory.'/'.$userDirectory.'/'.$this->imageDirectory;
        $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
        $fileName = date('Ymd').'_'.substr(microtime(), 2, 8).'_uploaded.'.$extension; // renaming image
        $request->file('image')->move($destinationPath, $fileName); // uploading file to given path

        //Storage::disk('images')->put($fileName, $request->file('image'));  // put image in storage

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
        $userDirectory = $user->username;
        //$thumbDestination = $this->thumbnailDirectory.'/'.$userDirectory;
        $thumbDestination = $this->usersDirectory.'/'.$userDirectory.'/'.$this->thumbnailDirectory;
        $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
        $fileThumbnailName = date('Ymd').'_'.substr(microtime(), 2, 8).'_thumb.'.$extension;
        $thumbnail = $this->resize($this->getImage());
        $fullPath = $thumbDestination."/".$fileThumbnailName;
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
        $opus->setImage($user, $request);
        $opus->setThumbnail($user, $request);

        return $opus;
    }
}