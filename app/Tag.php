<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     *  return all associated articles with the given tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected $fillable = ['name'];
    
    public function pieces()
    {
        return $this->belongsToMany('App\Piece')->withTimestamps();
    }
    
    public function opera()
    {
        return $this->belongsToMany('App\Opus')->withTimestamps();
    }
    
    public static function makeTags(Opus $opus, $tag_string){
        $tags = explode(' ', trim($tag_string));
        if(!empty($tags)) {
            foreach($tags as $tag) {
                if(Tag::where('name', $tag)->first() === null) {
                    Tag::create(['name'=>$tag]);
                }
            }
            $tagIds = [];
            foreach($tags as $tag) {
                $id = Tag::where('name', $tag)->value('id');
                array_push($tagIds, $id);
            }

            $opus->tags()->sync($tagIds);
        } else {
            return;
        }
    }
}
