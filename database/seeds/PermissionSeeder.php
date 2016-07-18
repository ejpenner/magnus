<?php

use Illuminate\Database\Seeder;

use Magnus\Permission;
use Magnus\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'schema_name'               => 'Developer',
            'role_id'                   => Role::where('level', config('roles.devLevel'))->value('id'),
            'role_code'                 => Role::where('role_code', config('roles.dev-code'))->value('role_code'),
            'user_opus_permission'      => 1,
            'user_comment_permission'   => 1,
            'user_gallery_permission'   => 1,
            'user_profile_permission'   => 1,
            'user_pm_permission'        => 1,
            'user_banned'               => 0,
            'admin_opus_permission'     => 1,
            'admin_comment_permission'  => 1,
            'admin_gallery_permission'  => 1,
            'admin_profile_permission'  => 1,
            'admin_pm_permission'       => 1,
            'admin_center_access'       => 1,
            'admin_handle_reports'      => 1,
            'admin_suspend_users'       => 1,
            'admin_ban_users'           => 1,
            'admin_mass_delete'         => 1,
            'admin_user_lookup'         => 1,
            'admin_mass_notify'         => 1,
            'admin_role_assign'         => 1,
            'admin_dev_tools'           => 1
        ]);

        Permission::create([
            'schema_name'               => 'Administrator',
            'role_id'                   => Role::where('level', config('roles.adminLevel'))->value('id'),
            'role_code'                 => Role::where('role_code', config('roles.admin-code'))->value('role_code'),
            'user_opus_permission'      => 1,
            'user_comment_permission'   => 1,
            'user_gallery_permission'   => 1,
            'user_profile_permission'   => 1,
            'user_pm_permission'        => 1,
            'user_banned'               => 0,
            'admin_opus_permission'     => 1,
            'admin_comment_permission'  => 1,
            'admin_gallery_permission'  => 1,
            'admin_profile_permission'  => 1,
            'admin_pm_permission'       => 1,
            'admin_center_access'       => 1,
            'admin_handle_reports'      => 1,
            'admin_suspend_users'       => 1,
            'admin_ban_users'           => 1,
            'admin_mass_delete'         => 1,
            'admin_user_lookup'         => 1,
            'admin_mass_notify'         => 1,
            'admin_role_assign'         => 1,
            'admin_dev_tools'           => 0
        ]);

        Permission::create([
            'schema_name'               => 'Global Moderator',
            'role_id'                   => Role::where('level', config('roles.globalModLevel'))->value('id'),
            'role_code'                 => Role::where('role_code', config('roles.gmod-code'))->value('role_code'),
            'user_opus_permission'      => 1,
            'user_comment_permission'   => 1,
            'user_gallery_permission'   => 1,
            'user_profile_permission'   => 1,
            'user_pm_permission'        => 1,
            'user_banned'               => 0,
            'admin_opus_permission'     => 1,
            'admin_comment_permission'  => 1,
            'admin_gallery_permission'  => 1,
            'admin_profile_permission'  => 1,
            'admin_pm_permission'       => 0,
            'admin_center_access'       => 1,
            'admin_handle_reports'      => 1,
            'admin_suspend_users'       => 1,
            'admin_ban_users'           => 0,
            'admin_mass_delete'         => 1,
            'admin_user_lookup'         => 1,
            'admin_mass_notify'         => 0,
            'admin_role_assign'         => 0,
            'admin_dev_tools'           => 0
        ]);

        Permission::create([
            'schema_name'               => 'Moderator',
            'role_id'                   => Role::where('level', config('roles.modLevel'))->value('id'),
            'role_code'                 => Role::where('role_code', config('roles.mod-code'))->value('role_code'),
            'user_opus_permission'      => 1,
            'user_comment_permission'   => 1,
            'user_gallery_permission'   => 1,
            'user_profile_permission'   => 1,
            'user_pm_permission'        => 1,
            'user_banned'               => 0,
            'admin_opus_permission'     => 1,
            'admin_comment_permission'  => 1,
            'admin_gallery_permission'  => 1,
            'admin_profile_permission'  => 0,
            'admin_pm_permission'       => 0,
            'admin_center_access'       => 1,
            'admin_handle_reports'      => 1,
            'admin_suspend_users'       => 0,
            'admin_ban_users'           => 0,
            'admin_mass_delete'         => 0,
            'admin_user_lookup'         => 1,
            'admin_mass_notify'         => 0,
            'admin_role_assign'         => 0,
            'admin_dev_tools'           => 0
        ]);

        Permission::create([
            'schema_name'               => 'User',
            'role_id'                   => Role::where('level', config('roles.userLevel'))->value('id'),
            'role_code'                 => Role::where('role_code', config('roles.user-code'))->value('role_code'),
            'user_opus_permission'      => 1,
            'user_comment_permission'   => 1,
            'user_gallery_permission'   => 1,
            'user_profile_permission'   => 1,
            'user_pm_permission'        => 1,
            'user_banned'               => 0,
            'admin_opus_permission'     => 0,
            'admin_comment_permission'  => 0,
            'admin_gallery_permission'  => 0,
            'admin_profile_permission'  => 0,
            'admin_pm_permission'       => 0,
            'admin_center_access'       => 0,
            'admin_handle_reports'      => 0,
            'admin_suspend_users'       => 0,
            'admin_ban_users'           => 0,
            'admin_mass_delete'         => 0,
            'admin_user_lookup'         => 0,
            'admin_mass_notify'         => 0,
            'admin_role_assign'         => 0,
            'admin_dev_tools'           => 0
        ]);

        Permission::create([
            'schema_name'               => 'Suspended',
            'role_id'                   => Role::where('level', config('roles.suspendedLevel'))->value('id'),
            'role_code'                 => Role::where('role_code', config('roles.suspended-code'))->value('role_code'),
            'user_opus_permission'      => 0,
            'user_comment_permission'   => 0,
            'user_gallery_permission'   => 0,
            'user_profile_permission'   => 0,
            'user_pm_permission'        => 0,
            'user_banned'               => 0,
            'admin_opus_permission'     => 0,
            'admin_comment_permission'  => 0,
            'admin_gallery_permission'  => 0,
            'admin_profile_permission'  => 0,
            'admin_pm_permission'       => 0,
            'admin_center_access'       => 0,
            'admin_handle_reports'      => 0,
            'admin_suspend_users'       => 0,
            'admin_ban_users'           => 0,
            'admin_mass_delete'         => 0,
            'admin_user_lookup'         => 0,
            'admin_mass_notify'         => 0,
            'admin_role_assign'         => 0,
            'admin_dev_tools'           => 0
        ]);

        Permission::create([
            'schema_name'               => 'Banned',
            'role_id'                   => Role::where('level', config('roles.bannedLevel'))->value('id'),
            'role_code'                 => Role::where('role_code', config('roles.banned-code'))->value('role_code'),
            'user_opus_permission'      => 0,
            'user_comment_permission'   => 0,
            'user_gallery_permission'   => 0,
            'user_profile_permission'   => 0,
            'user_pm_permission'        => 0,
            'user_banned'               => 1,
            'admin_opus_permission'     => 0,
            'admin_comment_permission'  => 0,
            'admin_gallery_permission'  => 0,
            'admin_profile_permission'  => 0,
            'admin_pm_permission'       => 0,
            'admin_center_access'       => 0,
            'admin_handle_reports'      => 0,
            'admin_suspend_users'       => 0,
            'admin_ban_users'           => 0,
            'admin_mass_delete'         => 0,
            'admin_user_lookup'         => 0,
            'admin_mass_notify'         => 0,
            'admin_role_assign'         => 0,
            'admin_dev_tools'           => 0
        ]);
    }
}
