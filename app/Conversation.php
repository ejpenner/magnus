<?php

namespace Magnus;

use Magnus\PrivateMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','created_at'];

    public function users() {
        $this->belongsToMany('Magnus\User', 'conversation_user');
    }

    public function messages() {
        $this->hasMany('Magnus\PrivateMessage', 'private_message_id');
    }

    public function addReply(PrivateMessage $message) {
        $this->messages()->save($message);
    }

    public function addUser(User $user) {
        $this->users()->attach($user);
    }

    public function removeUser(User $user) {
        $this->users()->detach($user);
    }
}
