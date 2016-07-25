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
        $galleryMax = 1;
        $opusMax = 10;
        $opusGalleryMax = 5;

        $opusFinalCount = $users->count() * (($galleryMax *  $opusGalleryMax) + $opusMax);
        $count = 0;

        fwrite(STDOUT, "\0337"); // save cli output position

        foreach($users as $user)  {
            foreach(range(1,$opusMax) as $index) {
                factory(Opus::class)->create(['user_id'=>$user->id]);
                $count++;
                fwrite(STDOUT, "\0338"."\033[0;36mOpusSeeder: ".number_format(100 * ($count / $opusFinalCount), 2)."% Complete \033[0m");
            }

            foreach(range(1,$galleryMax) as $index) {
                $user->galleries()->save(factory(Gallery::class)->make());
            }

            foreach($user->galleries as $gallery) {

                foreach(range(1,$opusGalleryMax) as $i)
                {

                    $opusG = factory(Opus::class)->create(['user_id'=>$user->id]);

                    //echo "\033[0;36m".$opusG."\033[0m\n\n";
                    $count++;
                    fwrite(STDOUT, "\0338"."\033[0;36mOpusSeeder: ".number_format(100 * ($count / $opusFinalCount), 2)."% Complete \033[0m");

                    $opusG->save();
                    $gallery->opera()->attach($opusG->id);
                }

            }
        }

        fwrite(STDOUT, PHP_EOL);
    }
}
