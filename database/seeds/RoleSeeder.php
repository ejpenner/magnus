<?php

use Illuminate\Database\Seeder;

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
        Role::create(['role_name'=>'Developer', 'level'=>70]);
        Role::create(['role_name'=>'Administrator', 'level'=>60]);
        Role::create(['role_name'=>'Global Moderator', 'level'=>50]);
        Role::create(['role_name'=>'Moderator', 'level'=>40]);
        Role::create(['role_name'=>'User', 'level'=>30]);
        Role::create(['role_name'=>'Suspended', 'level'=>20]);
        Role::create(['role_name'=>'Banned', 'level'=>10]);
    }
}
