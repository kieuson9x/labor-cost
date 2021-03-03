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
            'Luỹ kế theo kế hoạch' => 0,
            'Luỹ kế lương theo kế hoạch sản xuất' => 0,
            'Chi phí thực tế ERP' => 0
        ];

        for ($i = 1; $i <= 12; $i++) {
            $budgetPlan = data_get($department->getBudgetPlan($year, $i), 'amount');
            $actualBudget = $department->getTotalSalariesOfDepartment($year, $i);
            $budgetByAccounting = data_get($department->budgets()->where(['year' => $year, 'month' => $i])->latest()->first(), 'amount');

            $budgetData['Tổng']['Luỹ kế theo kế hoạch'] += $budgetPlan;
            $budgetData['Tổng']['Luỹ kế lương theo kế hoạch sản xuất'] += $actualBudget;
            $budgetData['Tổng']['Chi phí thực tế ERP'] += $budgetByAccounting;

            $budgetData["Tháng {$i}"] = [
                'Luỹ kế theo kế hoạch' => $budgetPlan,
                'Luỹ kế lương theo kế hoạch sản xuất' => $actualBudget,
                'Chi phí thực tế ERP' => $budgetByAccounting
            ];
        }

        // $budgetData = json_encode($budgetData);

        return view('reports.salary', compact('year', 'departmentId', 'departmentOptions', 'budgetData'));
    }
}
