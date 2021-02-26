<?php

namespace App\Modules\Employee\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $guarded = [];

    const MAPPING_OVERTIME_TYPE = [
        'Làm thêm ngày thường' => 'weekdays',
        'Làm thêm ngày CN' => 'sunday',
        'Làm thêm ngày lễ' => 'holiday',
        'Làm việc ban đêm' => 'night',
        'Làm thêm ban đêm ngày thường' => 'weekdays_night',
        'Làm thêm ban đêm ngày CN' => 'sunday_night',
        'Làm thêm ban đêm ngày lễ' => 'holiday_night',
    ];

    const MAPPING_OVERTIME_RATE = [
        'weekdays' => 1.5,
        'sunday' => 2.0,
        'holiday' => 3.0,
        'night' => 1.3,
        'weekdays_night' => 2.0,
        'sunday_night' => 2.7,
        'holiday_night' => 3.9,
    ];

    public function getTotalOvertimeSalary($basicSalary, $workingDays)
    {
        $sum = 0;

        foreach (Overtime::MAPPING_OVERTIME_RATE as $key => $rate) {
            $hour = data_get($this, $key);
            $sum += (($basicSalary / $workingDays) * $rate * ($hour / 8));
        }

        return $sum;
    }
}
