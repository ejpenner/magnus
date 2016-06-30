<?php

use Illuminate\Database\Seeder;
use Magnus\Opus;
use Magnus\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 60)->create();

        $opera = Opus::all();


        $tagCount = Tag::count();

        foreach($opera as $opus){
            foreach(range(1,3) as $i) {
                $tag = Tag::where('id', $this->UniqueRandomNumbersWithinRange(1, $tagCount, 1))->first();
                $opus->tags()->attach($tag->id);
            }
        }

    }

    private function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

}
