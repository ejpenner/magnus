<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['name','description', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
