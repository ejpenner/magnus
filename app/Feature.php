<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['gallery_id','piece_id'];

    /**
     * @return array
     */
    public function piece()
    {
        return $this->belongsTo('App\Piece');
    }

    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }


    public function scopeRecent($query) {
        $query->orderBy('created_at', 'desc');
    }
    
    
}
