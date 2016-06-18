<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['handle','content','type','read', 'opus_id','comment_id','message_id'];
    protected $casts = ['read'=>'boolean'];

    public function users() {
        return $this->belongsToMany('App\User', 'notification_user')->withTimestamps();
    }

    public function comment() {
        return $this->belongsTo('App\Comment');
    }

    public function opus() {
        return $this->belongsTo('App\Opus');
    }

    public function opusNotification(Opus $opus, User $user)
    {
        $this->opus_id = $opus->id;
        $user->notifications()->attach($this);
    }



}
