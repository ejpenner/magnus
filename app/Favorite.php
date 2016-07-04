<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = ['id','user_id'];
    
    public function user()
    {
        return $this->belongsTo('Magnus\User');
    }
    
    public function opus()
    {
        return $this->belongsTo('Magnus\Opuis');
    }
    
    
}
