<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;

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
        // New user permissions
        'user_opus_create' => 'boolean',
        'user_opus_edit' => 'boolean',
        'user_opus_destroy' => 'boolean',
        'user_comment_create' => 'boolean',
        'user_comment_edit' => 'boolean',
        'user_comment_destroy' => 'boolean',
        'user_gallery_create' => 'boolean',
        'user_gallery_edit' => 'boolean',
        'user_gallery_destroy' => 'boolean',
        'user_profile_edit' => 'boolean',
        'user_private_messages' => 'boolean',
        'user_banned' => 'boolean',
        // New admin permissions
        'admin_opus_edit' => 'boolean',
        'admin_opus_create' => 'boolean',
        'admin_opus_destroy' => 'boolean',
        'admin_gallery_edit' => 'boolean',
        'admin_gallery_create' => 'boolean',
        'admin_gallery_destroy' => 'boolean',
        'admin_comment_edit' => 'boolean',
        'admin_comment_create' => 'boolean',
        'admin_comment_destroy' => 'boolean',
        'admin_profile_edit' => 'boolean',
        'admin_private_messages' => 'boolean',
        'admin_center_access' => 'boolean',
        'admin_view_reports' => 'boolean',
        'admin_penalize_users' => 'boolean',
        'admin_close_reports' => 'boolean',
        'admin_suspend_users' => 'boolean',
        'admin_ban_users' => 'boolean',
        'admin_user_create' => 'boolean',
        'admin_user_edit' => 'boolean',
        'admin_user_destroy' => 'boolean',
        'admin_role_create' => 'boolean',
        'admin_role_edit' => 'boolean',
        'admin_role_destroy' => 'boolean',
        'admin_role_give' => 'boolean',
        'admin_role_revoke' => 'boolean',
        'admin_make_admins' => 'boolean',
        'admin_make_mods' => 'boolean',
        'admin_make_devs' => 'boolean',
        'admin_user_lookup' => 'boolean',
        'admin_mass_delete' => 'boolean',
        'admin_mass_notify' => 'boolean'
    ];
    
    /**
     * Permission schema belongs to one role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('Magnus\Role');
    }

    /**
     * Return's the schema name
     * @return mixed
     */
    public function getSchemaName()
    {
        return $this->attributes['schema_name'];
    }

    /**
     * Determines if a user has the specified permission if the specified
     * permission is not in the database return false anyway
     * @param User $user
     * @param $permission
     * @return bool
     */
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
