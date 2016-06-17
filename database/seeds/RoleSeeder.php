<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['role_name'=>Config::get('roles.developer'), 'level'=>Config::get('roles.devLevel')]);
        Role::create(['role_name'=>Config::get('roles.administrator'), 'level'=>Config::get('roles.adminLevel')]);
        Role::create(['role_name'=>Config::get('roles.globalMod'), 'level'=>Config::get('roles.globalModLevel')]);
        Role::create(['role_name'=>Config::get('roles.moderator'), 'level'=>Config::get('roles.modLevel')]);
        Role::create(['role_name'=>Config::get('roles.user'), 'level'=>Config::get('roles.userLevel')]);
        Role::create(['role_name'=>Config::get('roles.suspended'), 'level'=>Config::get('roles.suspendedLevel')]);
        Role::create(['role_name'=>Config::get('roles.banned'), 'level'=>Config::get('roles.bannedLevel')]);
    }
}
