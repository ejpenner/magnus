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
        $galleryMax = 2;
        $opusMax = 10;
        $opusGalleryMax = 10;
        $tagMax = 4;

        foreach($users as $user)  {
            foreach(range(1,$opusMax) as $index) {
                factory(Opus::class)->create(['user_id'=>$user->id])->each(function($opus) use ($tagMax) {
                    $tagCount = Tag::count();

                });
            }

            foreach(range(1,$galleryMax) as $index) {
                $user->galleries()->save(factory(Gallery::class)->make());
            }

            foreach($user->galleries as $gallery) {

                foreach(range(1,$opusGalleryMax) as $i)
                {
                    $opusG = factory(Opus::class)->create(['user_id'=>$user->id]);

                    echo $opusG."\n\n";;

                    $opusG->save();
                    $gallery->opera()->attach($opusG->id);
                }

            }
        }
    }
}
