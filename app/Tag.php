<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    /**
     * A Tag model belongs to many Opus models
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function opera()
    {
        return $this->belongsToMany('Magnus\Opus')->withTimestamps();
    }

    /**
     * A function that takes in an Opus and a string
     * and makes Tags from the string if they don't already
     * exist. Then for every tag that is not a duplicate,
     * attach it to the Opus and sync it with Tag
     *
     * @param Opus $opus
     * @param $tag_string
     */
    public static function make(Opus $opus, $tag_string)
    {
        if ($tag_string == '' or $tag_string == null) {
            return;
        } else {
            $tags = explode(' ', trim($tag_string));
            $tagIds = [];
            foreach ($tags as $tag) {
                $tagIds[] = Tag::firstOrCreate(['name' => strtolower($tag)])->getKey();
            }
            $opus->tags()->sync($tagIds);
        }
    }

//    public static function make(Opus $opus, $tag_string)
//    {
//        if ($tag_string != '') {
//            $tags = explode(' ', trim($tag_string));
//            foreach ($tags as $tag) {
//                Tag::firstOrCreate(['name'=>$tag]);
//            }
//
//            $tagIds = [];
//            foreach ($tags as $tag) {
//                $addTag = Tag::where('name', $tag)->first();
//                if (strtolower($addTag->name) == strtolower($tag)) {
//                        array_push($tagIds, $addTag->id);
//                }
//            }
//            $opus->tags()->sync($tagIds);
//        } else {
//            return;
//        }
//    }
}
