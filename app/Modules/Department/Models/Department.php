<?php

namespace App\Modules\Department\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Employee\Models\Employee;
use App\Modules\Department\Models\BudgetPlan;
use App\Modules\Department\Models\ProductPlan;
use App\Modules\Department\Models\DepartmentMetaData;

class Department extends Model
{
    protected $guarded = [];

    // Relationships
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function budgetPlans()
    {
        return $this->hasMany(BudgetPlan::class);
    }

    public function productPlans()
    {
        return $this->hasMany(ProductPlan::class, 'department_id', 'id');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'department_id', 'id');
    }

    public function data()
    {
        return $this->hasMany(DepartmentMetaData::class, 'department_id', 'id');
    }


    // Lấy kế hoạch phòng ban
    public function getBudgetPlan($year, $month = null)
    {
        if (!is_null($month)) {
            return $this->budgetPlans()->where(['year' => $year, 'month' => $month])->latest()->first();
        }

        return $this->budgetPlans()->where(['year' => $year])->latest()->get();
    }

    // // Lẩy tổng số tiền lương cả phòng theo tháng
    // public function getTotalSalariesOfDepartment($year, $month)
    // {
    //     $employees = $this->employees;

    //     if (empty($employees)) {
    //         return 0;
    //     }

    //     $sum = 0;

    //     $employees->each(function ($employee, $key) use (&$sum, $year, $month) {
    //         $employeeTotalSalaries = $employee->getTotalSalaryByMonth($year, $month);

    //         $sum += $employeeTotalSalaries;
    //     });

    //     return $sum;
    // }

    // Danh sách các phòng ban
    public static function getDepartmentOptions()
    {
        return Cache::remember('departments', 24 * 60, function () {
            return DB::table('departments')->get()->map(function ($item) {
                return [
                    'title' => $item->name,
                    'value' => $item->id
                ];
            })->toArray();
        });
    }

    // public function getNumberOfEmployees($date)
    // {
    //     return Cache::remember('number_of_employees', 24 * 60, function () use ($date) {
    //         return $this->employees()->whereHas('histories', function ($query) use ($date) {
    //             return $query->where('start_date', '<=', $date)
    //                 ->where('end_date', '>=', $date);
    //         })->count();
    //     });
    // }

    public function getTotalNeededTimeByPlan($condition)
    {
        $sum = 0;
        $this->productPlans()->where($condition)->each(function ($item) use (&$sum) {
            $sum += $item->product->rate * $item->quantity;
        });

        return $sum;
    }

    public function getTotalEmployees($condition)
    {
        return data_get($this->data()->where($condition)->first(), 'number_of_employees', 0);
    }

    public function getTotalNeededEmployeeByPlan($condition, $totalTimeNeededTime = null)
    {
        $workingDays = data_get($this->data()->where($condition)->first(), 'working_days', 22);

        if (is_null($totalTimeNeededTime)) {
            $totalTimeNeededTime = $this->getTotalNeededTimeByPlan($condition);
        }

        return $totalTimeNeededTime / (8 * $workingDays);
    }

    public function getActualEmployeeCost($condition, $totalNeedTimeByProductPlan)
    {
        $metaData = $this->data()->where($condition)->first();

        $numberOfEmployee = data_get($metaData, 'number_of_employees', 0);
        $averageSalary = data_get($metaData, 'average_salary', 0);
        $workingDays = data_get($metaData, 'working_days', 0);
        $workingHour = data_get($metaData, 'working_hours_per_day', 0);
        $overtimeHours = data_get($metaData, 'week_days_overtime_hours', 0);
        $totalWorkingHoursPerMonth = data_get($metaData, 'total_working_hours_per_month', 0);

        if ($workingHour === 0 || $workingDays === 0 || $averageSalary === 0 || $workingHour === 0) {
            return 0;
        }

        if ($totalWorkingHoursPerMonth < $totalNeedTimeByProductPlan) {
            $salaryPerHour = $averageSalary / ($workingDays * $workingHour);
            return $numberOfEmployee * $averageSalary + ($salaryPerHour * $overtimeHours * 1.5);
        }

        return  $numberOfEmployee * $averageSalary;
    }
}
