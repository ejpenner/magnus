<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Gallery extends Model
{
    protected $fillable = ['name', 'description', 'main_gallery', 'user_id'];

    protected $casts = [
        'main_gallery' => 'boolean'
    ];
    
    protected $dates = ['created_at','updated_at'];

    /**
     * Gallery model belongs to the User model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Gallery model belongs to many Opera
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function opera() {
        return $this->belongsToMany('App\Opus')->withTimestamps();
    }

    /**
     * Attribute updated_at mutator
     * @param $value
     */
    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = $value;
    }

    /**
     * Add the opus to this gallery
     * @param Opus $opus
     */
    public function addOpus(Opus $opus)
    {
        $this->updated_at = Carbon::now();
        $this->save();
        $this->opera()->attach($opus->id);
    }

    /**
     * Remove the opus from this gallery
     * @param Opus $opus
     */
    public function removeOpus(Opus $opus)
    {
        $this->updated_at = Carbon::now();
        $this->save();
        $this->opera()->detach($opus->id);
    }

    /**
     * Copy the Opus to another gallery
     * @param Opus $opus
     * @param Gallery $gallery
     */
    public function copyOpus(Opus $opus, Gallery $gallery)
    {
        $this->updated_at = Carbon::now();
        $this->save();
        $gallery->addOpus($opus);
    }

    /**
     * Move the opus to another gallery
     * @param Opus $opus
     * @param Gallery $gallery
     */
    public function moveOpus(Opus $opus, Gallery $gallery)
    {
        $this->removeOpus($opus);
        $gallery->addOpus($opus);
    }
    
    public static function place(Request $request, Opus $opus)
    {
        $gallery_ids = [];
        foreach($request->input('gallery_ids') as $id) {
                array_push($gallery_ids, $id);
        }
        if(count($gallery_ids) > 0) {
            foreach ($gallery_ids as $id) {
                Gallery::where('id', $id)->first()->addOpus($opus);
            }
        }
    }

    public static function makeDirectories(User $user)
    {
        File::makeDirectory(public_path('usr/'.$user->username.'/images'), 0755, true);
        File::makeDirectory(public_path('usr/'.$user->username.'/thumbnails'), 0755, true);
        File::makeDirectory(public_path('usr/'.$user->username.'/avatars'), 0755, true);
    }
}
