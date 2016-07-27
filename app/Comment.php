<?php

namespace Magnus;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'parent_id',
        'opus_id',
        'journal_id',
        'profile_id',
        'body',
        'deleted'
    ];
    
    protected $casts = [
        'deleted' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo('Magnus\User');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
//    public function opus()
//    {
//        return $this->belongsTo('Magnus\Opus');
//    }
//
//    public function profile()
//    {
//        return $this->belongsTo('Magnus\Profile');
//    }

//    public function journal()
//    {
//        $this->belongsTo('Magnus\Journal');
//    }

    public function childComments()
    {
        return $this->hasMany('Magnus\Comment', 'parent_id', 'id');
    }
    
    public function parentComment()
    {
        return $this->belongsTo('Magnus\Comment', 'parent_id');
    }

    public function allChildComments()
    {
        return $this->childComments()->with('allChildComments');
    }

    public function getCreatedAtAttribute($value)
    {
        if (isset(Auth::user()->timezone)) {
            return Carbon::parse($value)->timezone(Auth::user()->timezone)->format('M d, Y g:iA');
        } else {
            return Carbon::parse($value)->format('M d, Y g:iA');
        }
    }
}
