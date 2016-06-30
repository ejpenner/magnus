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
        Permission::create(['schema_name'=>'Administrator', 'role_id'=>Role::where('level', 60)->value('id'), 
            'read'=>1, 'edit'=>1, 'create'=>1, 'destroy'=>1,
            'create_all'=>1, 'read_all'=>1, 'edit_all'=>1, 'destroy_all'=>1,
            'gallery_all'=>1, 'piece_all'=>1, 'comment_all'=>1,
            'private_message_all' => 1, 'private_message_access'=>1, 'banned' => 0]);
        
        Permission::create(['schema_name'=>'Developer', 'role_id'=>Role::where('level', 70)->value('id'), 
            'read'=>1, 'edit'=>1, 'create'=>1, 'destroy'=>1,
            'create_all'=>1, 'read_all'=>1, 'edit_all'=>1, 'destroy_all'=>1,
            'gallery_all'=>1, 'piece_all'=>1, 'comment_all'=>1,
            'private_message_all' => 1, 'private_message_access'=>1, 'banned' => 0]);
        
        Permission::create(['schema_name'=>'Global Moderator', 'role_id'=>Role::where('level', 50)->value('id'),
            'read'=>1, 'edit'=>1, 'create'=>1, 'destroy'=>1,
            'create_all'=>1, 'read_all'=>1, 'edit_all'=>1, 'destroy_all'=>1,
            'gallery_all'=>1, 'piece_all'=>1, 'comment_all'=>1,
            'private_message_all' => 0, 'private_message_access'=>1, 'banned' => 0]);
        
        Permission::create(['schema_name'=>'Moderator', 'role_id'=>Role::where('level', 40)->value('id'),
            'read'=>1, 'edit'=>1, 'create'=>1, 'destroy'=>1,
            'create_all'=>0, 'read_all'=>0, 'edit_all'=>0, 'destroy_all'=>0,
            'gallery_all'=>1, 'piece_all'=>1, 'comment_all'=>1,
            'private_message_all' => 0, 'private_message_access'=>1, 'banned' => 0]);

        Permission::create(['schema_name'=>'User', 'role_id'=>Role::where('level', 30)->value('id'),
            'read'=>1, 'edit'=>1, 'create'=>1, 'destroy'=>1,
            'create_all'=>0, 'read_all'=>0, 'edit_all'=>0, 'destroy_all'=>0,
            'gallery_all'=>0, 'piece_all'=>0, 'comment_all'=>0,
            'private_message_all' => 0, 'private_message_access'=>1, 'banned' => 0]);

        Permission::create(['schema_name'=>'Suspended', 'role_id'=>Role::where('level', 20)->value('id'),
            'read'=>1, 'edit'=>0, 'create'=>0, 'destroy'=>0,
            'create_all'=>0, 'read_all'=>0, 'edit_all'=>0, 'destroy_all'=>0,
            'gallery_all'=>0, 'piece_all'=>0, 'comment_all'=>0,
            'private_message_all' => 0, 'private_message_access'=>0, 'banned' => 0]);

        Permission::create(['schema_name'=>'Banned', 'role_id'=>Role::where('level', 10)->value('id'),
            'read'=>0, 'edit'=>0, 'create'=>0, 'destroy'=>0,
            'create_all'=>0, 'read_all'=>0, 'edit_all'=>0, 'destroy_all'=>0,
            'gallery_all'=>0, 'piece_all'=>0, 'comment_all'=>0,
            'private_message_all' => 0, 'private_message_access'=>0, 'banned' => 1]);
    }
}
