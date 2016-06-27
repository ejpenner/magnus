<?php

use Illuminate\Database\Seeder;
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
        $opusMax = 4;
        $opusGalleryMax = 4;
        $tagMax = 4;
        
        foreach($users as $user)  {
            foreach(range(1,$opusMax) as $index) {
                factory(Opus::class)->create(['user_id'=>$user->id])->each(function($opus) use ($tagMax) {
                    $tagCount = Tag::count();

                    foreach(range(1, 1) as $j){
                        $tag = Tag::where('id', $this->UniqueRandomNumbersWithinRange(1,$tagCount,1))->first();
                        $opus->tags()->attach($tag->id);
                    }
                });
            }
            foreach(range(1,$galleryMax) as $index) {
                $user->galleries()->save(factory(Gallery::class)->make());
            }
            foreach($user->galleries as $gallery) {


                    $opus = factory(Opus::class)->create(['user_id'=>$user->id]);

                    echo $opus."\n\n";;

                    $opus->save();
                    $gallery->opera()->attach($opus->id);

                    $tagCount = Tag::count();

                    foreach(range(1,2) as $j){
                        $tag = Tag::where('id', $this->UniqueRandomNumbersWithinRange(1,$tagCount,1))->first();
                        $opus->tags()->attach($tag->id);
                        echo $tag."\n\n";;
                    }

            }
        }
    }

    private function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}
