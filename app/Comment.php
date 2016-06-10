<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'parent_id',
        'piece_id',
        'body'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function piece() {
        return $this->belongsTo('App\Piece');
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


}
