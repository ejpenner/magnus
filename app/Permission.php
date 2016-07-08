<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Permission extends Model
{
    protected $guarded = [
        'id', 'role_id'
    ];

    protected $casts = [
        'create' => 'boolean',
        'read' => 'boolean',
        'edit' => 'boolean',
        'destroy' => 'boolean',
        'create_all' => 'boolean',
        'read_all' => 'boolean',
        'edit_all' => 'boolean',
        'destroy_all' => 'boolean',
        'gallery_all' => 'boolean',
        'piece_all' => 'boolean',
        'comment_all' => 'boolean',
        'private_message_all' => 'boolean',
        'private_message_access' => 'boolean',
        'banned' => 'boolean',
        'user_opus_create' => 'boolean',
        'user_opus_edit' => 'boolean',
        'user_opus_destroy' => 'boolean',
        'user_comment_create' => 'boolean',
        'user_comment_edit' => 'boolean',
        'user_comment_destroy' => 'boolean',
        'user_gallery_create' => 'boolean',
        'user_gallery_edit' => 'boolean',
        'user_gallery_destroy' => 'boolean',

    ];

    public function getSchemaName()
    {
        return $this->attributes['schema_name'];
    }

    public function role()
    {
        return $this->belongsTo('Magnus\Role');
    }

    public static function hasPermission(User $user, $permission)
    {
        foreach ($user->roles as $userRoles) {
            try {
                $hasPermissions = Permission::where('schema_name', $userRoles->role_name)->value($permission); // fetch the permission column name
                return $hasPermissions;
            } catch (\Exception $e) {
                return false;
            }

        }
        return false;
    }
}
