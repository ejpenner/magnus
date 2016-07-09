<?php

namespace Magnus;

use Magnus\User;
use Magnus\Opus;
use Magnus\Notification;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = ['id'];
    
    public function users()
    {
        return $this->belongsToMany('Magnus\User', 'favorite_user')->withTimestamps();
    }

    /**
     * A favorite can only belong to one opus
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opus()
    {
        return $this->belongsTo('Magnus\Opus');
    }
    
    public function add(User $user)
    {
        if ($this->opus->user_id !== $user->id) {
            $user->favorites()->attach($this->id);
            return true;
        }
        return false;
    }

    public function remove(User $user)
    {
        $user->favorites()->detach($this->id);
    }

    public static function has(User $user, Opus $opus)
    {
        $favorites = $user->favorites->where(['opus_id'=>$opus->id]);
        dd($favorites);
//        $q = User::query();
//        $q->join('favorite_user', 'users.id', '=', 'favorite_user.user_id');
//        $q->join('favorites', 'favorites.id', '=', 'favorite_user.favorite_id');
//        $q->where('users.id', '=', $user->id)->where('favorites.opus_id', '=', $opus->id);
//        $results = $q->get();
//        if($results->count() > 0) {
//            return true;
//        } else {
//            return false;
//        }
    }
}
