<?php
namespace Magnus\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Collection;
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
        if ($user->id == $object->user_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * If on the search page, put the query in the search box
     * 
     * @return string
     */
    public static function getSearchQuery()
    {
        return Request::is('search/*') ? urldecode(Request::segment(2)) : '';
    }


    /**
     * Returns a collection of users that watch this user
     *
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
     *  Returns a collection of users that this user watches
     *
     * @return static
     */
    public function listWatchedUsers(User $user)
    {
        $watcherList = Collection::make();
        foreach($user->watchers as $i => $watcher) {
            if($this->id != $watcher->pivot->watched_user_id) {
                if($i >= 10) {
                    return $watcherList;
                }
                $watcherList->push(User::where('id', $watcher->pivot->watched_user_id)->first());
            }
        }
        return $watcherList;
    }
}