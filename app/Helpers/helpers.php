<?php

namespace Magnus\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Magnus\Gallery;
use Magnus\Opus;
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

    public static function perPage()
    {
        if (Request::has('limit')) {
            return Request::input('limit');
        } elseif (Auth::check() and !Request::has('limit')) {
            return Auth::user()->preferences->per_page;
        } else {
            return config('images.defaultLimit');
        }
    }

    /**
     * Returns a collection of users that watch this user
     * @param User $user
     * @return static
     */
    public static function listWatchers(User $user)
    {
        $watcherList = Collection::make();
        foreach ($user->watchedUsers as $i => $watcher) {
            if ($i >= 10) {
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
        foreach ($user->watchers as $i => $watcher) {
            if ($user->id != $watcher->pivot->watched_user_id) {
                if ($i >= 10) {
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
        File::makeDirectory(public_path('art/'.$username.'/previews'), 4664, true);
    }

    /**
     * Helper function to determine Role checks and owner checks on views
     * @param $object
     * @param $role
     * @return bool
     */
    public static function isOwnerOrHasRole($object, $role)
    {
        if (self::isOwner(Auth::user(), $object) or Auth::user()->atLeastHasRole($role)) {
            return true;
        }
        return false;
    }

    /**
     *  Make a navigator array with the id of the next and previous
     *  opus in a gallery
     * @param $gallery
     * @param $opus
     * @return array
     */
    public static function galleryNavigator(Gallery $gallery, Opus $opus)
    {
        $pieceNav = [];
        $galleryNav = [
            'next' => null,
            'current' => $opus->id,
            'previous' => null
        ];
        $foundMax = false;
        $foundMin = false;

        // get all the Opus ID in the gallery into an array
        foreach ($gallery->opera as $currentOpus) {
            array_push($pieceNav, $currentOpus->id);
        }

        // if there are only two opera in a gallery, the next and previous
        // links should be the opus it is not
        if (count($pieceNav) < 2) {
            $galleryNav['next'] = $pieceNav[0];
            $galleryNav['previous'] = $pieceNav[0];

            return $galleryNav;
        }

        // logic for a gallery with only three opera
        if (count($pieceNav) < 3) {
            if ($pieceNav[0] == $opus->id) {
                $galleryNav['next'] = $pieceNav[1];
                $galleryNav['previous'] = $pieceNav[1];
            } else {
                $galleryNav['next'] = $pieceNav[0];
                $galleryNav['previous'] = $pieceNav[0];
            }
            $galleryNav['current'] = $opus->id;

            return $galleryNav;
        }

        // logic for a gallery with more than three opera in it
        foreach ($pieceNav as $i => $id) {
            if ($opus->id == max($pieceNav) and $foundMax == false) {
                $foundMax = true;
                $galleryNav['next'] = min($pieceNav);
            } elseif ($id > $opus->id) {
                $galleryNav['next'] = $pieceNav[$i];
            } elseif ($opus->id == min($pieceNav) and $foundMin == false) {
                $foundMin = true;
                $galleryNav['previous'] = max($pieceNav);
            } elseif ($id < $opus->id) {
                $galleryNav['previous'] = $pieceNav[$i];
            }
        }
        $prev_id = $galleryNav['previous'];
        $next_id = $galleryNav['next'];
        $galleryNav['previous'] = Opus::where('id', $prev_id)->value('slug');
        $galleryNav['next'] = Opus::where('id', $next_id)->value('slug');

        return $galleryNav;
    }

    /**
     *  Make a navigator array with the id of the next and previous
     *  opus in a gallery
     * @param $gallery
     * @param $opus
     * @return array
     */
    public static function navigator($opera, Opus $opus)
    {
        $pieceNav = [];
        $galleryNav = [
            'next' => null,
            'current' => $opus->id,
            'previous' => null
        ];
        $foundMax = false;
        $foundMin = false;

        // get all the Opus ID in the gallery into an array
        foreach ($opera as $o) {
            array_push($pieceNav, $o->id);
        }

        // if there are only two opera in a gallery, the next and previous
        // links should be the opus it is not
        if (count($pieceNav) < 2) {
            $galleryNav['next'] = $pieceNav[0];
            $galleryNav['previous'] = $pieceNav[0];

            return $galleryNav;
        }

        // logic for a gallery with only three opera
        if (count($pieceNav) < 3) {
            if ($pieceNav[0] == $opus->id) {
                $galleryNav['next'] = $pieceNav[1];
                $galleryNav['previous'] = $pieceNav[1];
            } else {
                $galleryNav['next'] = $pieceNav[0];
                $galleryNav['previous'] = $pieceNav[0];
            }
            $galleryNav['current'] = $opus->id;

            return $galleryNav;
        }

        // logic for a gallery with more than three opera in it
        foreach ($pieceNav as $i => $id) {
            if ($opus->id == max($pieceNav) and $foundMax == false) {
                if ($galleryNav['next'] == null) {
                    $galleryNav['next'] = min($pieceNav);
                    $foundMax = true;
                }
            } elseif ($id > $opus->id) {
                if ($galleryNav['next'] == null) {
                    $galleryNav['next'] = $pieceNav[$i];
                }
            } elseif ($opus->id == min($pieceNav) and $foundMin == false) {
                $galleryNav['previous'] = max($pieceNav);
                $foundMin = true;
            } elseif ($id < $opus->id) {
                $galleryNav['previous'] = $pieceNav[$i];
            }
        }
        $prev_id = $galleryNav['previous'];
        $next_id = $galleryNav['next'];
        $galleryNav['previous'] = Opus::where('id', $prev_id)->value('slug');
        $galleryNav['next'] = Opus::where('id', $next_id)->value('slug');
        return $galleryNav;
    }

    /**
     * Handle the uploaded file, rename the file, move the file, return the filepath as a string
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected static function storeImage(User $user, Opus $opus, $request)
    {
        $originalFileName = $request->file('image')->getClientOriginalName();
        $fileName = $user->username.'-'.date('Ymd') . substr(microtime(), 2, 8).'-'.$originalFileName; // renaming image
        $request->file('image')->move($opus->directory, $fileName); // uploading file to given path
        $fullPath = $opus->directory."/".$fileName; // set the image field to the full path
        return $fullPath;
    }
}
