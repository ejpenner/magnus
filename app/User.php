<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Permission;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission_id', 'slug', 'username'
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
    
    public function permissions()
    {
        return $this->hasOne('App\Permission');
    }

    protected $appends = ['is_admin','is_user'];

    // methods
    public function hasRole($role)
    {
        if (Permission::where('role', $role)->value('id') == Auth::user()->permission_id) {
            return true;
        } else {
            return false;
        }
    }
    
    public function hasPermission($permission)
    {
        if (Permission::where('schema_name', $permission)->value('id') == Auth::user()->permission_id) {
            return true;
        } else {
            return false;
        }
    }

    public function getIsAdminAttribute()
    {
        if ($this->attributes['permission_id'] == Permission::where('schema_name', 'admin')->first()->value('id')) {
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

    /**
     * @return array
     */
    public function isOwner($object)
    {
       if($this->attributes['id'] == $object->user_id) {
           return true;
       } else {
           return false;
       }
    }
}
