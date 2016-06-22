<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsTo('App\Comment', 'parent_id', 'id');
    }

    public function allChildComments() {
        return $this->childComments()->with('allChildComments');
    }

    public function getCreatedAtAttribute($value) {
        if(isset(Auth::user()->timezone)) {
            return date_format(Carbon::parse($value)->timezone(Auth::user()->timezone), 'M d, Y g:iA');
        } else {
            return Carbon::parse($value);
        }
    }


}
