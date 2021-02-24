<?php

namespace App\Modules\WorkingDay\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $guarded = [];

    protected $casts = [
        'working_days' => 'double'
    ];

    /**
     * Additional attributes
     */
    public function getDaysInMonthAttribute()
    {
        return Carbon::createFromDate($this->year, $this->month)->startOfMonth()->daysInMonth;
    }
}
