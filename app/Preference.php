<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $guarded = ['id','user_id'];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
