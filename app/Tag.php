<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     *  return all associated articles with the given tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected $fillable = ['name'];
    
    public function pieces()
    {
        return $this->belongsToMany('App\Piece')->withTimestamps();
    }
}
