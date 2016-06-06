<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['name','description', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function featured()
    {
        return $this->hasMany('App\Feature');
    }
    
    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = $value;
    }
}
