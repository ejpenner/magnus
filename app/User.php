<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Permission;
use App\Profile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

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
    
    public function comments() {
        return $this->hasMany('App\Comment');
    }
    
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'user_roles');
    }

    protected $appends = ['banned'];
    
    /**
     *  Check if the user has the specified permission
     *
     * @param $action: string
     * @return bool|void
     */
    public function hasPermission($role) {
        if(Role::hasPermission($this, $role)) {
            return true;
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
        foreach(Auth::user()->roles as $userRoles) {
            if($userRoles->level >= Role::where('role_name', $role)->value('level')) {
                return true;
            }
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

}
