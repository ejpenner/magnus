<?php

use Illuminate\Database\Seeder;
use Magnus\User;
use Magnus\Preference;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
//        dd(factory(Preference::class)->make());
        foreach ($users as $user) {
            $user->preferences()->save(factory(Preference::class)->make());
        }
    }
}
