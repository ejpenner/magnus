<?php

use Illuminate\Database\Seeder;

use Magnus\User;
use Magnus\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        $users = User::all();

        foreach ($users as $user) {
            Profile::create(['user_id'=>$user->id, 'biography'=>$faker->text]);
        }
    }
}
