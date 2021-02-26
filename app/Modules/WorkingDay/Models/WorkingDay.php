<?php

namespace App\Modules\WorkingDay\Models;

use DatePeriod;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $guarded = [];

    protected $casts = [
        'working_days' => 'double'
    ];

    const MAPPING_TYPE = [
        'Ngày làm việc thực tế' => 'working_days',
        'Nghỉ hằng năm' => 'annual_days_off',
        'Nghỉ chiều thứ 7' => 'saturday_afternoon_day_off',
        'nghỉ lễ tết' => 'holiday',
    ];

    /**
     * Additional attributes
     */
    public function getDaysInMonthAttribute()
    {
        return Carbon::createFromDate($this->year, $this->month)->startOfMonth()->daysInMonth;
    }

    // Get number of a day in month
    public static function getDaysOff($year, $month, $daysInWeek)
    {
        $dayPositionInWeek = 0;

        if ($daysInWeek === 'saturday') {
            $dayPositionInWeek = 6;
        }

        return new DatePeriod(
            Carbon::createFromDate($year, $month)->firstOfMonth($dayPositionInWeek),
            CarbonInterval::week(),
            Carbon::createFromDate($year, $month + 1)->firstOfMonth($dayPositionInWeek),
        );
    }

    // Get normal working days which except weekends
    public static function getNormalWorkingDays($year, $month)
    {
        $date = Carbon::createFromDate($year, $month);
        $daysInMonth = $date->daysInMonth;
        $sundays = iterator_count(WorkingDay::getDaysOff($year, $month, 'sunday'));
        $saturdays = iterator_count(WorkingDay::getDaysOff($year, $month, 'saturday'));

        return $daysInMonth - $sundays - ($saturdays * 0.5);
    }
}
