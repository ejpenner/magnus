<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Input;
use File;
use Intervention\Image\Facades\Image;

class Opus extends Model
{
    protected $fillable =   ['image_path',
        'thumbnail_path',
        'title','comment','user_id',
        'published_at', 'views'];
    protected $dates = ['created_at', 'updated_at', 'published_at'];

    private $imageDirectory = 'images';
    private $thumbnailDirectory = 'thumbnails';
    private $resizeTo = 325;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
    
    public function galleries() {
        return $this->belongsToMany('App\Gallery')->withTimestamps();
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
     * @param $id
     */
    public function setUserIdAttribute($id)
    {
        $this->attributes['user_id'] = $id;
    }

    public function scopePublished($query) {
        $query->where('published_at', '<=', Carbon::now());
    }
    public function scopeUnpublished($query)
    {
        $query->where('published_at', '=>', Carbon::now());
    }
    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::parse($date);
        //$this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    public function getPublishedAtAttribute($value){
        return date_format(Carbon::parse($value), 'F j, Y');
    }

    public function view() {
        $this->views = $this->views++;
        $this->save();
    }

    /**
     * @return string
     */
    public function getImage()
    {
        if (!empty($this->image_path) && File::exists($this->image_path)) {  // $exists = Storage::disk('images')->has(basename($this->image_path));
            // Get the filename from the full path
            $filename = basename($this->image_path);
            return  $this->imageDirectory.'/'.$filename;
        }
        return $this->imageDirectory.'/missing.png';
    }
    /**
     * @return string
     */
    public function getThumbnail()
    {
        if (!empty($this->thumbnail_path) && File::exists($this->thumbnail_path)) {
            // Get the filename from the full path
            $filename = basename($this->thumbnail_path);
            return $this->thumbnailDirectory.'/'.$filename;
        }
        return $this->thumbnailDirectory.'/missing.png';
    }
    /**
     * @param $image
     * @return mixed
     */
    private function resize($image)
    {
        $resize = Image::make($image);

        $ratio = $resize->width() / $resize->height();

        if($ratio > 1){ // image is wider than tall
            $resize->resize($this->resizeTo, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else { // image is taller than wide
            $resize->resize(null, $this->resizeTo, function ($constraint) {
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
    public function storeImage($request)
    {
        $destinationPath = $this->imageDirectory; // upload path, goes to the public folder
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
    public function storeThumbnail($request)
    {
        $thumbDestination = $this->thumbnailDirectory;
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
    public function setImage($request)
    {
        $this->image_path = $this->storeImage($request);
    }

    /**
     *  using storeThumbnail(), also assign this article's thumbnail attribute the path returned
     * @param $request
     */
    public function setThumbnail($request)
    {
        $this->thumbnail_path = $this->storeThumbnail($request);
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
    public function updateImage($request)
    {
        if ($request->file('image') !== null) {  /// check if an image is attached
            if ($this->deleteImages()) {
                $this->setImage($request); // update the image
                $this->setThumbnail($request); // update the thumbnail
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
     * @return array
     */
    public function metadata() {
        $img = Image::make($this->getImage());
        $size = ceil($img->fileSize()/1000);
        return ['filesize'=>$size.' KB', 'resolution'=>$img->width() .'x'.$img->height()];
    }
}
