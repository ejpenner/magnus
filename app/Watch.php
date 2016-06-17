<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Watch;
use Illuminate\Support\Facades\Auth;

class Watch extends Model
{
    /**
     * This model represents users watching another user. A user who is
     * watching another user will receive notifications of updates and
     * actions the watched user has made
     */
    protected $table="watches";

    protected $fillable = [
        'user_id', 'watch_opus', 'watch_comments', 'watch_activity'
    ];

    protected $casts = [
        'opus_watch' => 'boolean',
        'comment_watch' => 'boolean',
        'activity_watch' => 'boolean'
    ];

    public function users() {
        return $this->belongsToMany('App\User', 'user_watch', 'watcher_user_id', 'user_id')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function watchUser(User $user, $opus, $comment, $activity)
    {
        $watch = Watch::create(['user_id'=>$user->id, 'watch_opus'=>$opus, 'watch_comments'=>$comment, 'watch_activity'=>$activity]);
        Auth::user()->watchedUsers()->attach($watch->id);
    }

}
