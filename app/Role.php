<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role_name', 'level'];

    /**
     * Role model has 1:1 relationship with Permission model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission() {
        return $this->hasOne('App\Permission');
    }

    /**
     * Role model has a M:N relationship with User model 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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
    public static function atLeastHasRole(User $user, $role) {
        foreach($user->roles as $userRole) {
            if($userRole->level >= Role::where('role_name', $role)->value('level')) {
                return true;
            }
        }
        return false;
    }

    /**
     *  Check if the user has exactly the role specified
     * @param User $user
     * @param $role
     * @return bool
     */
    public static function hasRole(User $user, $role) {
        foreach($user->roles as $userRole) {
            if($userRole->level == Role::where('role_name', $role)->value('level')) {
                return true;
            }
        }
        return false;
    }
}
