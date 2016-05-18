<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id'];
    
    public function User() {
        return $this->belongsTo('App\User');
    }
}
