<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['gallery_id','piece_id'];

    /**
     * @return array
     */
    public function Piece()
    {
        return $this->hasOne('App\Piece');
    }

    public function Gallery()
    {
        return $this->belongsToMany('App\Gallery');
    }
}
