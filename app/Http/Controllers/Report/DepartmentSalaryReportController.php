<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;

use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\Department;

class DepartmentSalaryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salary(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $departmentId = $request->input('department_id', 0);

        // Danh sách phòng ban
        $departmentOptions = Department::getDepartmentOptions();
        // array_push($departmentOptions, [
        //     'title'  =>  'All',
        //     'value'  => 'all'
        // ]);

        $department = Department::find($departmentId) ?? Department::first();
        $budgetData = array();
        $budgetData['Tổng'] = [
            'Kế hoạch' => 0,
            'Thực tế' => 0
        ];

        for ($i = 1; $i <= 12; $i++) {
            $budgetPlan = data_get($department->getBudgetPlan($year, $i), 'amount');
            $actualBudget = $department->getTotalSalariesOfDepartment($year, $i);

            $budgetData['Tổng']['Kế hoạch'] += $budgetPlan;
            $budgetData['Tổng']['Thực tế'] += $actualBudget;

            $budgetData["Tháng {$i}"] = [
                'Kế hoạch' => $budgetPlan,
                'Thực tế' => $actualBudget
            ];
        }

        // $budgetData = json_encode($budgetData);

        return view('reports.salary', compact('year', 'departmentId', 'departmentOptions', 'budgetData'));
    }
}
