<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;

use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\Department;
use App\Modules\WorkingDay\Models\WorkingDay;

class DepartmentLaborCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $departmentId = $request->input('department_id', 0);

        $departmentOptions = Department::getDepartmentOptions();
        $department = Department::find($departmentId) ?? Department::first();

        $numberOfEmployeeData = array();
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate($year, $i)->startOfMonth();
            $numberOfEmployee = $department->employees()->whereHas('histories', function ($query) use ($date) {
                return $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
            })->count();

            $numberOfEmployeeData["Tháng {$i}"] = [$numberOfEmployee];
        }

        $totalNeededTimeData = array();
        $totalNeededEmployeeData = array();

        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate($year, $i)->startOfMonth();
            $sum = 0;
            $productPlanTime = $department->productPlans()->where('month', $i)->where('year', $year)->each(function ($item) use (&$sum) {
                $sum += $item->product->rate * $item->quantity;
            });

            $workingDays = WorkingDay::where(['month' => $i, 'year' => $year])->first()->working_days ?? WorkingDay::getNormalWorkingDays($year, $i);

            $totalNeededTimeData["Tháng {$i}"] = $sum;
            $totalNeededEmployeeData["Tháng {$i}"] = $sum / (8 * $workingDays);
        }

        return view('reports.labor_cost', compact('year', 'departmentId', 'departmentOptions', 'numberOfEmployeeData', 'totalNeededTimeData', 'totalNeededEmployeeData'));
    }
}
