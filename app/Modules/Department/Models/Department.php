<?php

namespace App\Modules\Department\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Employee\Models\Employee;
use App\Modules\Department\Models\BudgetPlan;

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


    // Lấy kế hoạch phòng ban
    public function getBudgetPlan($year, $month = null)
    {
        if (!is_null($month)) {
            return $this->budgetPlans()->where(['year' => $year, 'month' => $month])->latest()->first();
        }

        return $this->budgetPlans()->where(['year' => $year])->latest()->get();
    }

    // Lẩy tổng số tiền lương cả phòng theo tháng
    public function getTotalSalariesOfDepartment($year, $month)
    {
        $employees = $this->employees;

        if (empty($employees)) {
            return 0;
        }

        $sum = 0;

        $employees->each(function ($employee, $key) use (&$sum, $year, $month) {
            $employeeTotalSalaries = $employee->getTotalSalaryByMonth($year, $month);

            $sum += $employeeTotalSalaries;
        });

        return $sum;
    }

    // Danh sách các phòng ban
    public static function getDepartmentOptions()
    {
        return Cache::remember('users', 24 * 60, function () {
            return DB::table('departments')->get()->map(function ($item) {
                return [
                    'title' => $item->name,
                    'value' => $item->id
                ];
            })->toArray();
        });
    }
}
