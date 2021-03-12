<?php

namespace App\Http\Controllers\Department;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Department\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = Department::withCount('employees')->get();

        return view('departments.index', compact('departments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $departmentId)
    {
        $year = (int) ($request->get('year') ?? Carbon::now()->year);

        $department = Department::findOrFail($departmentId);
        $departmentEmployees = $department->data();

        $budgetData = $this->getBudgetData($year, $departmentId);
        $laborCostData =  $this->getLaborData($year, $departmentId);

        return view('departments.show', compact('departmentId', 'year', 'department', 'departmentEmployees', 'budgetData', 'laborCostData'));
    }

    public function getBudgetData($year, $departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $budgetData = array();

        $budgetData['Tổng'] = [
            'Luỹ kế theo kế hoạch' => 0,
            'Luỹ kế lương theo kế hoạch sản xuất' => 0,
            'Chi phí thực tế ERP' => 0,
            'Luỹ kế so sánh' => 0,
            'Vượt' => 0,
        ];

        for ($i = 1; $i <= 12; $i++) {
            $condition = ['year' => $year, 'month' => $i];
            $budgetPlan = data_get($department->getBudgetPlan($year, $i), 'amount');

            $totalTimeNeeded = $department->getTotalNeededTimeByPlan($condition);
            $actualBudget = $department->getActualEmployeeCost($condition, $totalTimeNeeded);

            $budgetByAccounting = data_get($department->budgets()->where($condition)->latest()->first(), 'amount');

            $budgetData['Tổng']['Luỹ kế theo kế hoạch'] += $budgetPlan;
            $budgetData['Tổng']['Luỹ kế lương theo kế hoạch sản xuất'] += $actualBudget;
            $budgetData['Tổng']['Chi phí thực tế ERP'] += $budgetByAccounting;
            $comparableBudget = $budgetByAccounting ? $budgetByAccounting : $actualBudget;
            $budgetData['Tổng']['Luỹ kế so sánh'] += $comparableBudget;


            $budgetData["Tháng {$i}"] = [
                'Luỹ kế theo kế hoạch' => $budgetPlan,
                'Luỹ kế lương theo kế hoạch sản xuất' => $actualBudget,
                'Chi phí thực tế ERP' => $budgetByAccounting,
                'Luỹ kế so sánh' => $comparableBudget,
                'Vượt' => $comparableBudget > $budgetPlan,
            ];
        }

        data_set($budgetData, 'Tổng.Vượt', data_get($budgetData, 'Tổng.Luỹ kế so sánh') > data_get($budgetData, 'Tổng.Luỹ kế theo kế hoạch'));

        return $budgetData;
    }

    public function getLaborData($year, $departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $laborCostData = array();

        for ($i = 1; $i <= 12; $i++) {
            $condition = ['year' => $year, 'month' => $i];
            $totalEmployeesNeeded = $department->getTotalNeededEmployeeByPlan($condition);
            $totalEmployees = $department->getTotalEmployees($condition);

            $laborCostData["Tháng {$i}"] = [
                'Số nhân công có' => $totalEmployees,
                'Số nhân công cần' => $totalEmployeesNeeded,
                'Vượt' => round($totalEmployeesNeeded) > round($totalEmployees)
            ];
        }

        return $laborCostData;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $pk = $request->input('pk');
        $value = $request->input('value');

        $data = $department->data()->firstOrCreate([
            'month' => $request->input('name'),
            'year' => $request->input('year')
        ]);


        $data->update([
            $request->input('pk') => $pk === 'average_salary' ? VND_to_number($value) : $value,
        ]);

        $data->refresh();

        $budgetData = $this->getBudgetData((int) $request->input('year'), $departmentId);

        return ['success' => true, 'total_working_hours_in_month' => $data->total_working_hours_in_month, 'month' => $data->month, 'budgetData' => $budgetData];
    }
}
