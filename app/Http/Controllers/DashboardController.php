<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\BudgetPlan;
use App\Modules\Department\Models\Department;
use App\Modules\WorkingDay\Models\WorkingDay;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = (int) ($request->get('year') ?? Carbon::now()->year);

        $departmentOptions = Department::getDepartmentOptions();
        $dashboardData = array();
        $dashboardData['overall'] = [];
        $dashboardData['salary_cost'] = [];
        $dashboardData['employee_needed'] = [];

        // Tổng quan lương
        foreach ($departmentOptions as $option) {
            $department = Department::find($option['value']);

            $overallData = array();
            $salaryCostData = array();
            $employeeData = array();

            for ($i = 1; $i <= 12; $i++) {
                $budgetPlan = (float) data_get($department->getBudgetPlan($year, $i), 'amount');
                $actualBudget = (float) $department->getTotalSalariesOfDepartment($year, $i);
                $actualBudgetByAccounting = (float) data_get($department->budgets()->where(['year' => $year, 'month' => $i])->latest()->first(), 'amount');
                $compareActualBudget = (int) $actualBudgetByAccounting === 0 ? $actualBudget : $actualBudgetByAccounting;

                $date = Carbon::createFromDate($year, $i)->startOfMonth();
                $numberOfEmployees = $department->getNumberOfEmployees($date);
                $sum = 0;
                $productPlanTime = $department->productPlans()->where('month', $i)->where('year', $year)->each(function ($item) use (&$sum) {
                    $sum += $item->product->rate * $item->quantity;
                });
                $workingDays = WorkingDay::where(['month' => $i, 'year' => $year])->first()->working_days ?? WorkingDay::getNormalWorkingDays($year, $i);
                $employeeNeeded = $sum / (8 * $workingDays);

                data_set($overallData, 'total.plan', data_get($overallData, 'total.plan', 0) + $budgetPlan);
                data_set($overallData, 'total.actual', data_get($overallData, 'total.actual', 0) + $compareActualBudget);

                data_set($salaryCostData, 'total', data_get($salaryCostData, 'total', 0) + $actualBudget);

                $overallData[$i] = $compareActualBudget > $budgetPlan ? false : true;
                $salaryCostData[$i] = $actualBudget;
                $employeeData[$i] = [
                    'is_overload' => $employeeNeeded > $numberOfEmployees,
                    'needed' => $employeeNeeded
                ];
            }

            $totalOverallActual = (int) data_get($overallData, 'total.actual', 0);
            $totalOverallPlan = (int) data_get($overallData, 'total.plan', 0);

            if ($totalOverallActual > $totalOverallPlan) {
                data_set($overallData, 'total', false);
            } else if ($totalOverallActual === 0 && $totalOverallPlan === 0) {
                data_set($overallData, 'total', true);
            }


            data_set($dashboardData, "overall." . $department->id, $overallData);
            data_set($dashboardData, "salary_cost." . $department->id, $salaryCostData);
            data_set($dashboardData, "employee_needed." . $department->id, $employeeData);
        }

        return view('dashboard', compact('dashboardData', 'year', 'departmentOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $departmentId = $request->input('department_id');
        $year = $request->input('year');
        $month = $request->input('month');

        $budgetPlan = BudgetPlan::where(['year' => $year, 'month' => $month, 'department_id' => $departmentId])->latest()->first();
        if ($budgetPlan) {
            $budgetPlan->update([
                'amount' => VND_to_number($request->input('value'))
            ]);
        }

        $budgetPlan->refresh();

        return ['success' => true];
    }
}
