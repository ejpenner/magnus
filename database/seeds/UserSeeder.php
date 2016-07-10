<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Magnus\User;
use Magnus\Role;
use Magnus\Preference;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vilest = User::create(['name'=>'Eric', 'username'=>'Vilest', 'slug' => 'vilest', 'email'=>'ayy@lm.ao',
            'password'=>'$2y$10$2vC4FBlXEw9jAp2mHX/I1ereZawBmX.tipKbEIfMlQo1g6VytHkQa', 'timezone'=>'America/Chicago']);
        $vilest->roles()->attach(Role::where('role_name', 'Developer')->value('id'));
        Magnus::makeDirectories('vilest');

        factory(User::class,10)->create()
            ->each(function($user){
                $user->roles()->attach(Role::where('role_name', Config::get('roles.user'))->value('id'));
            });
        
    }
}
