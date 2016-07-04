<?php

namespace Magnus;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Watch extends Model
{

    protected $table = "watches";

    protected $fillable = [
        'user_id', 'watcher_user_id', 'watch_opus',
        'watch_comments', 'watch_activity', 'add_friend'
    ];

    protected $casts = [
        'opus_watch' => 'boolean',
        'comment_watch' => 'boolean',
        'activity_watch' => 'boolean',
        'add_friend' => 'boolean'
    ];
    
    public function users() {
        return $this->belongsToMany('Magnus\User', 'user_watch', 'watch_id', 'watcher_user_id')->withPivot('watched_user_id')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo('Magnus\User');
    }

    /**
     * Auth'd user will watch target $user
     *
     * @param User $user
     * @param Request $request
     */
    public static function watchUser(User $watcher, User $watched, Request $request)
    {
        $opus = $request->input('watch_opus') ? 1 : 0;
        $comment = $request->input('watch_comments') ? 1 : 0;
        $activity = $request->input('watch_activity') ? 1 : 0;
        $friend = $request->input('add_friend') ? 1 : 0;

        $watch = Watch::create(['user_id'=>$watched->id,
                                'watcher_user_id'=>$watcher->id,
                                'watch_opus'=>$opus, 'watch_comments'=>$comment,
                                'watch_activity'=>$activity,
                                'add_friend' => $friend
        ]);
        $watcher->watchers()->attach($watch->id,['watched_user_id'=>$watched->id]);
    }

    public static function modifyWatchUser()
    {

    }

    /**
     * Auth::user() will unwatch $user
     *
     * @param User $user
     */
    public static function unwatchUser(User $watcher, User $watched)
    {
        $watch = $watcher->watchers()->where('user_id', $watched->id)->where('watches.watcher_user_id', $watcher->id)->first();
        $watcher->watchers()->detach($watch->id);
        $watch->delete();
    }



}
