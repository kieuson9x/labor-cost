<?php

namespace App\Modules\Employee\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\Department;
use App\Modules\WorkingDay\Models\WorkingDay;
use App\Modules\Employee\Models\EmployeeHistory;

class Employee extends Model
{
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'employee_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany(EmployeeHistory::class, 'employee_id', 'id');
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class, 'employee_id', 'id');
    }

    public static function getEmployeeCode($prefix, $id)
    {
        return $prefix + $id;
    }

    public function countDays($year, $month, $ignore)
    {
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date("n", $counter) == $month) {
            if (in_array(date("w", $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime("+1 day", $counter);
        }
        return $count;
    }

    public function getTotalSalaryByMonth($year, $month)
    {
        $date = Carbon::createFromDate($year, $month);

        $basicSalaryObj = $this->salaries()->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->latest()
            ->first();

        if (is_null($basicSalaryObj)) {
            $basicSalaryObj = $this->salaries()->latest()->first();
        }

        $basicSalary = $basicSalaryObj->amount;

        $workingDays = WorkingDay::where(['month' => $month, 'year' => $year])->first()->working_days
            ?? WorkingDay::getNormalWorkingDays($year, $month);


        $overtime = $this->overtimes()->where(['month' => $month, 'year' => $year])->first();

        $total = $overtime ? $basicSalary + $overtime->getTotalOvertimeSalary($basicSalary, $workingDays) : $basicSalary;

        return $total;
    }
}
