<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateMessage extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','created_at'];

    public function user() {
        $this->belongsTo('Magnus\User', 'user_id');
    }

    public function conversation() {
        $this->belongsTo('Magnus\Conversation', 'conversation_id');
    }


}
