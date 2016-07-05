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
        Tag::create(['name' => 'ayy']);
        Tag::create(['name' => 'lmao']);
        Tag::create(['name' => 'traditional']);
        Tag::create(['name' => 'digital']);
        Tag::create(['name' => 'painting']);
        Tag::create(['name' => 'sketch']);
        Tag::create(['name' => 'watercolor']);
        Tag::create(['name' => 'colored']);
        Tag::create(['name' => 'pencil']);
        Tag::create(['name' => 'photography']);
        Tag::create(['name' => 'abstract']);
        Tag::create(['name' => 'canvas']);
        Tag::create(['name' => 'surreal']);
        Tag::create(['name' => 'nouveau']);
        Tag::create(['name' => 'art']);
        Tag::create(['name' => 'architecture']);
        Tag::create(['name' => 'portrait']);
        Tag::create(['name' => 'landscape']);
        Tag::create(['name' => 'still_life']);
        Tag::create(['name' => 'nude']);
        Tag::create(['name' => 'self-portrait']);

        factory(Tag::class, 40)->create();

        $opera = Opus::all();
        $tagCount = Tag::count();

        foreach($opera as $opus){
            foreach(range(1,6) as $i) {
                $tag = Tag::where('id', $this->UniqueRandomNumbersWithinRange(1, $tagCount, 1))->first();
                if(!$opus->hasTag($tag))
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
