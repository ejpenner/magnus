<?php

use Illuminate\Database\Seeder;
use Magnus\Notification;
use Magnus\Favorite;
use Magnus\User;
use Magnus\Opus;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $opera = Opus::all();
        foreach($opera as $opus)
        {
            Favorite::create(['opus_id' => $opus->id]);
        }

        $favorites = Favorite::all();
        $favorites = $favorites->shuffle();
        $users = User::all();

        foreach($users as $user)
        {
            foreach(range(1,5) as $i)
            {
                $fav = $favorites->first();
                $add = $fav->add($user);
                if(!$add) {
                    $favorites = $favorites->shuffle();
                    $fav = $favorites->first();
                    $fav->add($user);
                    Notification::notifyCreatorNewFavorite($fav);
                } else {
                    Notification::notifyCreatorNewFavorite($fav);
                }
                $favorites = $favorites->shuffle();
            }
            $favorites = $favorites->shuffle();
        }
    }
}
