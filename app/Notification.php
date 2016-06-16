<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['handle','content','type','read'];
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



}
