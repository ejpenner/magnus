<?php

use Illuminate\Database\Seeder;

use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['schema_name'=>'Admin', 'role'=>'admin', 'read'=>1, 'edit'=>1, 'create'=>1, 'destroy'=>1,
            'create_all'=>1, 'read_all'=>1, 'edit_all'=>1, 'destroy_all'=>1]);
        Permission::create(['schema_name'=>'Read Only', 'role'=>'read_only', 'read'=>1, 'edit'=>0, 'create'=>0, 'destroy'=>0,
            'create_all'=>0, 'read_all'=>0, 'edit_all'=>0, 'destroy_all'=>0]);
        Permission::create(['schema_name'=>'User', 'role'=>'user', 'read'=>1, 'edit'=>1, 'create'=>1, 'destroy'=>1,
            'create_all'=>0, 'read_all'=>0, 'edit_all'=>0, 'destroy_all'=>0]);
    }
}
