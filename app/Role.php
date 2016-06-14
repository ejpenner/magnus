<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role_name'];
    
    public function permission() {
        return $this->hasOne('App\Permission');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'user_roles');
    }
}
