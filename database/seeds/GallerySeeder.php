<?php

use Illuminate\Database\Seeder;

use Magnus\User;
use Magnus\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $faker = Faker\Factory::create();

        foreach($users as $user) {
            foreach (range(1,1) as $index) {
                Gallery::create(['name'=>$faker->word, 'description' => $faker->text, 'user_id' => $user->id]);
            }
        }
    }
}
