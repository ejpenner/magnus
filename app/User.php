<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','permission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function galleries()
    {
        return $this->hasMany('App\Gallery');
    }
    
    public function pieces()
    {
        return $this->hasMany('App\Piece');
    }
    
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    protected $appends = ['is_admin','is_user'];

    // methods
    public function hasRole($role)
    {
        if (User::where('permission_id', $role)->value('permission_id') == Auth::user()->permission_id) {
            return true;
        } else {
            return false;
        }
    }

    public function getIsAdminAttribute()
    {
        if ($this->attributes['permission_id'] == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function canEdit()
    {
        if ($this->permission == 'admin' or $this->permission == 'user') {
            return true;
        } else {
            return false;
        }
    }
}
