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
        return $this->belongsTo('App\Permission');
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

    /**
     *  Does the authorized user have the permission schema needed?
     *
     * @param $permission
     * @return bool
     */
    
    public function hasSchema($schema)
    {
        if (Permission::where('schema_name', $schema)->value('id') == Auth::user()->permission_id) {
            return true;
        } else {
            return false;
        }
    }

    public function hasPermission($action) {
        if (Permission::where($action, true)->value($action) == Auth::user()->permissions[$action]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Is this user an admin?
     *
     * @return bool
     */

    public function getIsAdminAttribute()
    {
        if ($this->attributes['permission_id'] == Permission::where('schema_name', 'admin')->first()->value('id')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Is this user the owner of an object
     *
     * @return boolean
     */
    public function isOwner($object)
    {
        if ($this->attributes['id'] == $object->user_id) {
            return true;
        } else {
            return false;
        }
    }
}
