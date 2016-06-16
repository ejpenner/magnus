<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role_name', 'level'];
    
    public function permission() {
        return $this->hasOne('App\Permission');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'user_roles');
    }

    /**
     *  Check if the user has sufficient permission level
     *
     * @param $user
     * @param $role
     * @return bool
     */

    public static function hasRole($user, $role) {
        foreach($user->roles as $userRole) {
            if($userRole->level >= Role::where('role_name', $role)->value('level')) {
                return true;
            }
        }
        return false;
    }
}
