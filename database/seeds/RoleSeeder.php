<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

use Magnus\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['role_name' => Config::get('roles.developer'),
                      'level' => Config::get('roles.devLevel'),
                      'role_code' => Config::get('roles.dev-code')]);
        
        Role::create(['role_name' => Config::get('roles.administrator'),
                      'level' => Config::get('roles.adminLevel'),
                      'role_code' => Config::get('roles.admin-code')]);
        
        Role::create(['role_name' => Config::get('roles.globalMod'),
                      'level' => Config::get('roles.globalModLevel'),
                      'role_code' => Config::get('roles.gmod-code')]);
        
        Role::create(['role_name' => Config::get('roles.moderator'),
                      'level' => Config::get('roles.modLevel'),
                      'role_code' => Config::get('roles.mod-code')]);
        
        Role::create(['role_name' => Config::get('roles.user'),
                      'level' => Config::get('roles.userLevel'),
                      'role_code' => Config::get('roles.user-code')]);
        
        Role::create(['role_name' => Config::get('roles.suspended'),
                      'level' => Config::get('roles.suspendedLevel'),
                      'role_code' => Config::get('roles.suspended-code')]);
        
        Role::create(['role_name' => Config::get('roles.banned'),
                      'level' => Config::get('roles.bannedLevel'),
                      'role_code' => Config::get('roles.banned-code')]);
        
    }
}
