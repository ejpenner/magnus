<?php
namespace Magnus\Helpers;

use Illuminate\Support\Facades\Config;
use Magnus\Role;
use Magnus\User;
use Illuminate\Support\Facades\Request;

class Helpers
{
    public static function usernameID($id)
    {
        $user = User::findOrFail($id);
        if (Role::atLeastHasRole($user, Config::get('roles.developer'))) {
            return "<span class=\"username role-developer\">$user->username</span>";
        } elseif (Role::atLeastHasRole($user, Config::get('roles.administrator'))) {
            return "<span class=\"username role-administrator\">$user->username</span>";
        } elseif (Role::atLeastHasRole($user, Config::get('roles.globalMod'))) {
            return "<span class=\"username role-globalModerator\">$user->username</span>";
        } elseif (Role::atLeastHasRole($user, Config::get('roles.moderator'))) {
            return "<span class=\"username role-moderator\">$user->username</span>";
        } elseif (Role::hasRole($user, Config::get('roles.banned'))) {
            return "<span class=\"username role-banned\">$user->username</span>";
        } else {
            return "<span class=\"username\">$user->username</span>";
        }
    }
    
    public static function isOwner(User $user, $object)
    {
        if ($user->id == $object->user_id) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function getSearchQuery()
    {
        return Request::is('search/*') ? urldecode(Request::segment(2)) : '';
    }
}