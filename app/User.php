<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Permission;
use App\Profile;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission_id', 'slug', 'username', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    private $avatarDirectory = 'avatars';
    private $avatarResize = '150';
    
    public function galleries()
    {
        return $this->hasMany('App\Gallery');
    }
    
    public function pieces()
    {
        return $this->hasMany('App\Piece');
    }
    
    public function opera() {
        return $this->hasMany('App\Opus');
    }
    
    public function comments() {
        return $this->hasMany('App\Comment');
    }
    
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles');
    }
    
    public function notifications()
    {
        return $this->belongsToMany('App\Notification', 'notification_user')->withTimestamps();
    }

    /**
     *  List of users as Watch models that this user watches
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchedUsers()
    {
        return $this->belongsToMany('App\Watch', 'user_watch', 'watched_user_id', 'watch_id')->withPivot('watcher_user_id')->withTimestamps();
    }

    /**
     *  Returns a list of users that follow this user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany('App\Watch', 'user_watch', 'watcher_user_id', 'watch_id')->withPivot('watched_user_id')->withTimestamps();
    }
    
    /**
     *  Check if the user has the specified permission
     *
     * @param $action: string
     * @return bool|void
     */
    public function hasPermission($permission) {
        foreach(Auth::user()->roles as $userRoles) {
            foreach($userRoles->permission->attributes as $key => $value) {
                return Permission::where('schema_name', $userRoles->role_name)->value($permission);
            }
        }
        return false;
    }
    
    /**
     *  Check if the logged in user has the specified role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if(Role::hasRole($this, $role)) {
            return true;
        }
        return false;
    }

    /**
     *  Check if the user has at least the specified role
     * @param $role
     * @return bool
     */
    public function atLeastHasRole($role)
    {
        if(Role::atLeastHasRole($this, $role)) {
            return true;
        }
        return false;
    }

    /**
     *  Does the authorized user have the permission schema
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

    public function storeAvatar($request)
    {
        $destinationPath = $this->avatarDirectory; // upload path, goes to the public folder
        $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
        if($extension == null or $extension == '') {
            $extension = 'png';
        }
        $fileName = substr(microtime(), 2, 8).'_uploaded.'.$extension; // renaming image

        $request->file('image')->move($destinationPath, $fileName); // uploading file to given path

        $fullPath = $destinationPath."/".$fileName; // set the image field to the full path
        return $fullPath;
    }

    public function setAvatar($request)
    {
        if($this->avatar != null or $this->avatar != '') {
            $this->deleteAvatarFile();
        }
        $this->avatar = $this->storeAvatar($request);

        $avatarResized = $this->resize($this->avatar);
        $avatarResized->save($this->avatar);
    }

    public function resize($image)
    {
        $resize = Image::make($image);
        $resize->resize($this->avatarResize, null, function ( $constraint )
        {
            $constraint->aspectRatio();
        });
        return $resize;
    }

    public function getAvatar()
    {
        if(!empty($this->avatar) && File::exists($this->avatar))
        {
            // Get the filename from the full path
            $filename = basename($this->avatar);
            return '/'.$this->avatarDirectory.'/'.$filename;
        }
        return '/avatars/missing/missing.png';
    }

    public function deleteAvatarFile()
    {
        $path = public_path();
        if(File::delete($path.'/'.$this->avatar))
        {
            return true;
        }
        return false;
    }
    
    public function listRoles() {
        $roles = [];
        foreach($this->roles as $role) {
            array_push($roles, $role->role_name);
        }
        $roles = implode(', ', $roles);
        return $roles;
    }

    /**
     *  Get the number of unread messages the user has
     * @return mixed
     */
    public function messageCount() {
        $q = Notification::query();
        $q->join('notification_user', 'notifications.id', '=', 'notification_user.notification_id');
        $q->join('users', 'users.id', '=', 'notification_user.user_id');
        $q->where('notification_user.user_id', $this->id);
        $q->where('notifications.read', '0');
        $r = $q->count();
        return $r;
    }

    public function notifyOpus(Notification $notification) {
        $this->notifications()->attach($notification->id);
    }


    /**
     * Returns a collection of users that watch this user
     *
     * @return static
     */
    public function listWatchers() {
        $watcherList = Collection::make();
        foreach($this->watchedUsers as $watcher) {
                $watcherList->push(User::where('id', $watcher->pivot->watcher_user_id)->first());
        }
        return $watcherList;
    }


    /**
     *  Returns a collection of users that this user watches
     *  TODO: WORKS
     *
     * @return static
     */
    public function listWatchedUsers()
    {
        $watcherList = Collection::make();
        foreach($this->watchers as $watcher) {
            if($this->id != $watcher->pivot->watched_user_id) {
                $watcherList->push(User::where('id', $watcher->pivot->watched_user_id)->first());
            }
        }
        return $watcherList;
    }

    public function notifyWatchersNewOpus(Opus $opus) {
        $notification = Notification::create([
            'handle'=>'opus',
            'opus_id' => $opus->id,
            'content' => $opus->title
        ]);
        
        foreach($this->watchers as $watcher) {
            if($watcher->id != $this->id) {
                $watcher->notifyOpus($notification);
            }
        }
    }

}