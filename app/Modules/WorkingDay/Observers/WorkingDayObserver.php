<?php

namespace App\Modules\WorkingDay\Observers;

use Illuminate\Support\Arr;
use App\Modules\WorkingDay\Models\WorkingDay;

class WorkingDayObserver
{
    /**
     * Handle the WorkingDay "creating" event.
     *
     * @param  \App\WorkingDay  $user
     * @return void
     */
    public function updated(WorkingDay $workingDay)
    {
        $changes = $workingDay->getDirty();

        // if (!empty($changes) && is_null(data_get($changes, 'working_days'))) {
        //     $normalWorkingDays = WorkingDay::getNormalWorkingDays($workingDay->year, $workingDay->month);
        //     $realWorkingDays = $normalWorkingDays - $workingDay->annual_days_off - $workingDay->saturday_afternoon_day_off - $workingDay->holiday;

        //     $workingDay->update([
        //         'working_days' => $realWorkingDays
        //     ]);
        // }

        return $workingDay;
    }
}
