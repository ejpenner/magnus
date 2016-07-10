<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Preference extends Model
{
    protected $fillable = [
        'sex', 'show_dob', 'per_page', 'date_of_birth'
    ];

    protected $dates = ['date_of_birth'];

    protected $dateFormat = 'F j, Y';
    
    protected $casts = [
        'show_sex' => 'boolean'
    ];
    
    public function user()
    {
        return $this->belongsTo('Magnus\User');
    }

    public static function makeDOB($day, $month, $year)
    {
        return Carbon::createFromDate($year, $month, $day);
    }
}
