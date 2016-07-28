<?php

use Magnus\User;
use Magnus\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach($users as $user) {
            foreach (range(1,5) as $index) {
                $user->journals()->save(factory(Journal::class)->make());
            }
        }
    }
}
