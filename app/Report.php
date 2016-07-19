<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = ['id'];

    public function reportedUser()
    {
        return $this->belongsTo('Magnus\User', 'reported_user_id');
    }

    public function reportedByUser()
    {
        return $this->belongsTo('Magnus\User', 'reporting_user_id');
    }

    public function adminUser()
    {
        return $this->belongsTo('Magnus\User', 'admin_user_id');
    }

    public function opus()
    {
        return $this->belongsTo('Magnus\Opus');
    }
}
