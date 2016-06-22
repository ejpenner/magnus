<?php

use Illuminate\Database\Seeder;
use App\Watch;
use App\User;

class WatchSeeder extends Seeder
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
            foreach($users as $watcher) {
                if($user->id != $watcher->id) {
                    $user->watchers()->attach(factory(Watch::class)->create(['user_id' => $watcher->id])->id,['watched_user_id'=>rand(1, User::count())]);
                    //$user->watchers()->attach(factory(Watch::class)->create(['user_id' => $user->id])->id,[]);
                }
            }
        }
    }
}
