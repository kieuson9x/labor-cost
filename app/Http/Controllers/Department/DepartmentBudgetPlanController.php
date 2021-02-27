<?php

namespace App\Http\Controllers\Department;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\BudgetPlan;
use App\Modules\Department\Models\Department;

class DepartmentBudgetPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->get('year') ?? Carbon::now()->year;

        $budgetPlans = BudgetPlan::where('year', $year)->orderBy('month')->get();
        $departmentOptions = Department::getDepartmentOptions();

        return view('budget_plans.index', compact('budgetPlans', 'year', 'departmentOptions'));
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
