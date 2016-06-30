<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Magnus\User;
use Magnus\Role;
use Magnus\Gallery;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vilest = User::create(['name'=>'Furrman', 'username'=>'Vilest', 'slug' => 'vilest', 'email'=>'murrus@purr.us',
            'password'=>'$2y$10$2vC4FBlXEw9jAp2mHX/I1ereZawBmX.tipKbEIfMlQo1g6VytHkQa', 'timezone'=>'America/Chicago']);
        File::makeDirectory(public_path('art/'.$vilest->username.'/images'), 0755, true);
        File::makeDirectory(public_path('art/'.$vilest->username.'/thumbnails'), 0755, true);
        File::makeDirectory(public_path('art/'.$vilest->username.'/avatars'), 0755, true);
        $vilest->roles()->attach(Role::where('role_name', 'Developer')->value('id'));


        factory(User::class,10)->create()
            ->each(function($user){
                $user->roles()->attach(Role::where('role_name', Config::get('roles.user'))->value('id'));
            });
    }
}
