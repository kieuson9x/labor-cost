<?php

namespace App\Modules\Department\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentMetaData extends Model
{
    protected $guarded = [];

    public function getTotalWorkingHoursInMonthAttribute()
    {
        return $this->number_of_employees * $this->working_hours_per_day * $this->working_days;
    }
}
