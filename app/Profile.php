<?php

namespace App;

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

    public function listWatchers() {
        $watcherList = [];
        foreach($this->user->watchers as $watcher) {
            User::where('id', $watcher->pivot->watcher_user_id)->get()->toArray();
        }
    }
}
