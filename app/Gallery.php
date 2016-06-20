<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['name', 'description', 'main_gallery', 'user_id'];

    protected $casts = [
        'main_gallery' => 'boolean'
    ];

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
        $this->opera()->dettach($opus->id);
    }
}
