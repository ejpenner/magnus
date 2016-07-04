<?php
namespace Magnus\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Magnus\Role;
use Magnus\User;


class Helpers
{
    /**
     * Returns a decorated username based on  the id supplied
     * 
     * @param $id
     * @return string
     */
    public static function username($id)
    {
        $user = User::findOrFail($id);
        if (Role::atLeastHasRole($user, Config::get('roles.dev-code'))) {
            return "<span class=\"username role-developer\">$user->username</span>";
        } elseif (Role::atLeastHasRole($user, Config::get('roles.admin-code'))) {
            return "<span class=\"username role-administrator\">$user->username</span>";
        } elseif (Role::atLeastHasRole($user, Config::get('roles.gmod-code'))) {
            return "<span class=\"username role-globalModerator\">$user->username</span>";
        } elseif (Role::atLeastHasRole($user, Config::get('roles.mod-code'))) {
            return "<span class=\"username role-moderator\">$user->username</span>";
        } elseif (Role::hasRole($user, Config::get('roles.banned-code'))) {
            return "<span class=\"username role-banned\">$user->username</span>";
        } else {
            return "<span class=\"username\">$user->username</span>";
        }
    }

    /**
     * Check to see if the user owns the object
     * 
     * @param User $user
     * @param $object
     * @return bool
     */
    public static function isOwner(User $user, $object)
    {
        try {
            if ($user->id == $object->user_id) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * If on the search page, put the query in the search box
     * @return string
     */
    public static function getSearchQuery()
    {
        return Request::is('search/*') ? urldecode(Request::segment(2)) : '';
    }


    /**
     * Returns a collection of users that watch this user
     * @param User $user
     * @return static
     */
    public static function listWatchers(User $user)
    {
        $watcherList = Collection::make();
        foreach($user->watchedUsers as $i => $watcher) {
            if($i >= 10) {
                return $watcherList;
            }
            $watcherList->push(User::where('id', $watcher->pivot->watcher_user_id)->first());
        }
        return $watcherList;
    }
    
    /**
     * Returns a collection of users that this user watches
     * @param User $user
     * @return static
     */
    public static function listWatchedUsers(User $user)
    {
        $watcherList = Collection::make();
        foreach($user->watchers as $i => $watcher) {
            if($user->id != $watcher->pivot->watched_user_id) {
                if($i >= 10) {
                    return $watcherList;
                }
                $watcherList->push(User::where('id', $watcher->pivot->watched_user_id)->first());
            }
        }
        return $watcherList;
    }

    /**
     * Makes directories for a given string
     * @param $username
     */
    public static function makeDirectories($username)
    {
        $username = strtolower($username);
        File::makeDirectory(public_path('art/'.$username.'/images'), 4664, true);
        File::makeDirectory(public_path('art/'.$username.'/thumbnails'), 4664, true);
        File::makeDirectory(public_path('art/'.$username.'/avatars'), 4664, true);
    }

    /**
     * Helper function to determine Role checks and owner checks on views
     * @param $object
     * @param $role
     * @return bool
     */
    public static function isOwnerOrHasRole($object, $role)
    {
        if(self::isOwner(Auth::user(), $object) or Auth::user()->atLeastHasRole($role))
        {
            return true;
        }
        return false;
    }
}