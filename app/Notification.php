<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['handle','content','type','read', 'opus_id','comment_id','message_id'];
    protected $casts = ['read'=>'boolean'];

    /**
     * Notification has a M:N relationship with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany('App\User', 'notification_user')->withTimestamps();
    }

    /**
     * Notification has a 1:1 relationship with Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment() {
        return $this->belongsTo('App\Comment');
    }

    /**
     * Notification has a 1:1 relationship with Opus model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opus() {
        return $this->belongsTo('App\Opus');
    }

    public function opusNotification(Opus $opus, User $user)
    {
        $this->opus_id = $opus->id;
        $user->notifications()->attach($this->id);
    }

    public function notify(User $user) {
        $user->notifications()->attach($this->id);
    }
}
