<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Profile;

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
