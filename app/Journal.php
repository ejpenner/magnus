<?php

namespace Magnus;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','user_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo('Magnus\User');
    }

    public function comments()
    {
        return $this->morphMany('Magnus\Comment', 'commentable');
    }

    public function commentCount()
    {
        return $this->morphMany('Magnus\Comment', 'commentable')->selectRaw('commentable_id, count(*) as count')->groupBy('commentable_id');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = substr(microtime(), 15).'-'.str_slug($value);;
    }

    public function getCreatedAtAttribute($value)
    {
        if (isset(Auth::user()->timezone)) {
            return Carbon::parse($value)->timezone(Auth::user()->timezone)->format('F j, Y g:i A');
        } else {
            return Carbon::parse($value)->format('F j, Y g:i A');
        }
    }
}
