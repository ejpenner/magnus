<?php

namespace Magnus;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    private $artDirectory = 'art';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'permission_id', 'slug', 'username',
        'avatar', 'timezone', 'directory'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at'];

    private $avatarDirectory = 'avatars';
    private $avatarResize = '150';

    /**
     * User has 0:M relationship with Gallery model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany('Magnus\Gallery');
    }

    /**
     * User model has 0:M relationship with Opus model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opera()
    {
        return $this->hasMany('Magnus\Opus');
    }

    /**
     * User has a M:N relationship with Favorites
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany('Magnus\Favorite', 'favorite_user')->withTimestamps();
    }

    /**
     * User model has 0:M relationship with Comment model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Magnus\Comment');
    }

    /**
     *  User model's 1:1 relationship with Profile model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('Magnus\Profile');
    }

    /**
     *  User has M:N relationship with Roles model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('Magnus\Role', 'user_roles');
    }

    /**
     * User has M:N relationship with Notification model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notifications()
    {
        return $this->belongsToMany('Magnus\Notification', 'notification_user')->withTimestamps();
    }

    /**
     *  List of users as Watch models that this user watches
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchedUsers()
    {
        return $this->belongsToMany('Magnus\Watch', 'user_watch', 'watched_user_id', 'watch_id')->withPivot('watcher_user_id')->withTimestamps();
    }

    /**
     *  Returns a list of users that follow this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany('Magnus\Watch', 'user_watch', 'watcher_user_id', 'watch_id')->withPivot('watched_user_id')->withTimestamps();
    }

    /**
     * User has one site preferences model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function preferences()
    {
        return $this->hasOne('Magnus\Preference');
    }

    /**
     *  Return some span formatting around names for fancy CSS output
     *
     * @return string
     */
    public function decorateName()
    {
        if (Role::atLeastHasRole($this, Config::get('roles.dev-code'))) {
            return "<span class=\"username role-developer\">$this->name</span>";
        } elseif (Role::atLeastHasRole($this, Config::get('roles.admin-code'))) {
            return "<span class=\"username role-administrator\">$this->name</span>";
        } elseif (Role::atLeastHasRole($this, Config::get('roles.gmod-code'))) {
            return "<span class=\"username role-globalModerator\">$this->name</span>";
        } elseif (Role::atLeastHasRole($this, Config::get('roles.mod-code'))) {
            return "<span class=\"username role-moderator\">$this->name</span>";
        } else {
            return "<span class=\"username\">$this->name</span>";
        }
    }

    /**
     *  Return some span formatting around usernames for fancy CSS output
     *
     * @return string
     */
    public function decorateUsername()
    {
        if (Role::atLeastHasRole($this, Config::get('roles.dev-code'))) {
            return "<span class=\"username role-developer\">$this->username</span>";
        } elseif (Role::atLeastHasRole($this, Config::get('roles.admin-code'))) {
            return "<span class=\"username role-administrator\">$this->username</span>";
        } elseif (Role::atLeastHasRole($this, Config::get('roles.gmod-code'))) {
            return "<span class=\"username role-globalModerator\">$this->username</span>";
        } elseif (Role::atLeastHasRole($this, Config::get('roles.mod-code'))) {
            return "<span class=\"username role-moderator\">$this->username</span>";
        } elseif (Role::hasRole($this, Config::get('roles.banned-code'))) {
            return "<span class=\"username role-banned\">$this->username</span>";
        } else {
            return "<span class=\"username\">$this->username</span>";
        }
    }

    /**
     *  Check if the user has the specified permission
     *
     * @param $action: string
     * @return bool|void
     */
    public function hasPermission($permission)
    {

    }

    /**
     *  Check if the logged in user has the specified role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (Role::hasRole($this, $role)) {
            return true;
        }
        return false;
    }

    /**
     * Check if the user has at least the specified role
     *
     * @param $role
     * @return bool
     */
    public function atLeastHasRole($role)
    {
        if (Role::atLeastHasRole($this, $role)) {
            return true;
        }
        return false;
    }

    /**
     * Does the authorized user have the permission schema
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

    /**
     *  Store the image stored within the Request
     *  Return the relative path of the file
     *
     * @param $request
     * @return string
     */
    public function storeAvatar($request)
    {

        //$destinationPath = $this->avatarDirectory; // upload path, goes to the public folder
        $destinationPath = $this->artDirectory.'/'.$this->username.'/'.$this->avatarDirectory;
        $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
        if ($extension == null or $extension == '') {
            $extension = 'png';
        }
        $fileName = substr(microtime(), 2, 8).'_uploaded.'.$extension; // renaming image

        $request->file('image')->move($destinationPath, $fileName); // uploading file to given path

        $fullPath = $destinationPath."/".$fileName; // set the image field to the full path
        return $fullPath;
    }

    /**
     *  Set the user's avatar
     *
     * @param $request
     */
    public function setAvatar($request)
    {
        if ($this->avatar != null or $this->avatar != '') {
            $this->deleteAvatarFile();
        }
        $this->avatar = $this->storeAvatar($request);

        $avatarResized = $this->resize($this->avatar);
        $avatarResized->save($this->avatar);
    }

    /**
     *  Resize the user's uploaded avatar
     *
     * @param $image
     * @return Image
     */
    public function resize($image)
    {
        $resize = Image::make($image);
        $resize->resize($this->avatarResize, null, function ($constraint) {
        
            $constraint->aspectRatio();
        });
        return $resize;
    }

    /**
     *  Return the relative URL of this user's avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        if (!empty($this->avatar) && File::exists($this->avatar)) {
            return '/'.$this->avatar;
        }
        return '/images/missing/missing-avatar.png';
    }

    /**
     * Delete the user's avatar file
     *
     * @return bool
     */
    public function deleteAvatarFile()
    {
        $path = public_path();
        if (File::delete($path.'/'.$this->avatar)) {
            return true;
        }
        return false;
    }

    /**
     * Returns an string of all of the user's roles
     *
     * @return array|string
     */
    public function listRoles()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            array_push($roles, $role->role_name);
        }
        $roles = implode(', ', $roles);
        return $roles;
    }

    /**
     *  Get the number of unread messages the user has
     *
     * @return mixed
     */
    public function messageCount()
    {
        $q = Notification::query();
        $q->join('notification_user', 'notifications.id', '=', 'notification_user.notification_id');
        $q->join('users', 'users.id', '=', 'notification_user.user_id');
        $q->where('notification_user.user_id', $this->id);
        $q->where('notifications.read', '0');
        $r = $q->count();
        return $r;
    }

    /**
     *  Notify this user of a new Opus/Comment/Activity of a user they watch
     *
     * @param \Magnus\Notification $notification
     * @return void
     */
    public function notify(Notification $notification)
    {
        $this->notifications()->attach($notification->id);
    }

    /**
     *  Delete notification ID from the user's message center
     *
     * @param Notification $notification
     */
    public function deleteNotification(Notification $notification)
    {
        $this->notifications()->detach($notification->id);
    }

    /**
     *  Determine if this user is being watched by you.
     *
     * @param User $user
     * @return bool
     */
    public function isWatched(User $user)
    {
        $watch = Watch::where('user_id', $user->id)->where('watcher_user_id', $this->id)->count();
//        $watches = Watch::where('user_id',$user->id)->get();
        if ($watch > 0) {
            return true;
        }
//        $watch = Watch::where('user_id',$user->id)->first();
//
//        foreach ($watches as $watch)
//        {
//            dd($watch->users);
//            if($watch->pivot->watcher_user_id == $this->id)
//            {
//                return true;
//            }
//        }
        return false;
    }
}
