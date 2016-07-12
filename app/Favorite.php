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
        if (!$user->isOwner($this->opus)) {
            $user->favorites()->attach($this->id);
            return true;
        }
        return false;
    }

    public function remove(User $user)
    {
        if (!$user->isOwner($this->opus)) {
            $user->favorites()->detach($this->id);
            return true;
        }
        return false;
    }

    public static function has(User $user, Opus $opus)
    {
        $favorites = $user->favorites;

        foreach ($favorites as $favorite) {
            if ($favorite->opus_id === $opus->id) {
                return true;
            }
        }
        return false;
    }
}
