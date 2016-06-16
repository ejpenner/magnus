<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['name', 'description', 'main_gallery', 'user_id'];

    protected $casts = [
        'main_gallery' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function opera() {
        return $this->belongsToMany('App\Opus')->withTimestamps();
    }
    
    public function featured()
    {
        return $this->hasMany('App\Feature');
    }
    
    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = $value;
    }
}
