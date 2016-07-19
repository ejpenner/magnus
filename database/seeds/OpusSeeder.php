<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Magnus\User;
use Magnus\Opus;
use Magnus\Tag;
use Magnus\Gallery;

class OpusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $galleryMax = 3;
        $opusMax = 15;
        $opusGalleryMax = 5;

        foreach($users as $user)  {
            foreach(range(1,$opusMax) as $index) {
                factory(Opus::class)->create(['user_id'=>$user->id]);
            }

            foreach(range(1,$galleryMax) as $index) {
                $user->galleries()->save(factory(Gallery::class)->make());
            }

            foreach($user->galleries as $gallery) {

                foreach(range(1,$opusGalleryMax) as $i)
                {
                    $opusG = factory(Opus::class)->create(['user_id'=>$user->id]);

                    echo "\033[01;31m".$opusG."\033[0m\n\n";;

                    $opusG->save();
                    $gallery->opera()->attach($opusG->id);
                }

            }
        }
    }
}
