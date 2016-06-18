<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id','biography'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }
    
    public function listWatchedUsers()
    {
        $watcherList = [];
        foreach($this->user->watchedUsers as $watcher) {
            array_push($watcherList, ['name'=>$watcher->name, 'id'=>$watcher->id, 'slug'=>$watcher->slug]);
        }
        return $watcherList;
    }

//    public function listWatchers() {
//        $watcherList = Collection::make();
//        foreach($this->user->watchers as $watcher) {
//              $watcherList->push(User::where('id', $watcher->user_id)->first());
//        }
//        return $watcherList;
//    }
}
