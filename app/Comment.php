<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'parent_id',
        'opus_id',
        'body'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function opus()
    {
     return $this->belongsTo('App\Opus');
    }
    
    public function profile() {
        return $this->belongsTo('App\Profile');
    }

    public function childComments() {
        return $this->hasMany('App\Comment','parent_id','id');
    }
    
    public function parentComment() {
        return $this->hasOne('App\Comment', 'id', 'parent_id');
    }

    public function allChildComments() {
        return $this->childComments()->with('allChildComments');
    }

    public function getCreatedAtAttribute($value) {
        return date_format(Carbon::parse($value), 'm/j/Y H:iA');
    }


}
