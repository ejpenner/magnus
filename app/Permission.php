<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [
        'id', 'role_id'
    ];

    protected $casts = [
        // New user permissions
        'user_opus_permission'      => 'boolean', // Allows users to submit art
        'user_comment_permission'   => 'boolean',
        'user_gallery_permission'   => 'boolean',
        'user_profile_permission'   => 'boolean',
        'user_private_messages'     => 'boolean',
        'user_banned'               => 'boolean',
        // New admin permissions
        'admin_opus_permission'     => 'boolean',
        'admin_gallery_permission'  => 'boolean',
        'admin_comment_permission'  => 'boolean',
        'admin_profile_permission'  => 'boolean',
        'admin_pm_permission'       => 'boolean',
        'admin_center_access'       => 'boolean',
        'admin_handle_reports'      => 'boolean',
        'admin_suspend_users'       => 'boolean',
        'admin_ban_users'           => 'boolean',
        'admin_user_permission'     => 'boolean',
        'admin_role_permission'     => 'boolean',
        'admin_role_assign'         => 'boolean',
        'admin_make_admins'         => 'boolean',
        'admin_make_mods'           => 'boolean',
        'admin_make_devs'           => 'boolean',
        'admin_user_lookup'         => 'boolean',
        'admin_mass_delete'         => 'boolean',
        'admin_mass_notify'         => 'boolean',
        'admin_dev_tools'           => 'boolean'
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
                $hasPermissions = Permission::where('role_code', $userRoles->role_code)->value($permission); // fetch the permission column name
                return $hasPermissions;
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }
}
