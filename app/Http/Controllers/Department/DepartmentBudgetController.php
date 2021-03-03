<?php

namespace App\Http\Controllers\Department;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Department\Models\Budget;
use App\Modules\Department\Models\Department;
use App\Modules\Department\Models\ProductPlan;

class DepartmentBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->get('year') ?? Carbon::now()->year;

        $budgets = Budget::where(['year' => $year])->orderBy('month')->get();;

        $departmentOptions = Department::getDepartmentOptions();

        return view('budgets.index', compact('budgets', 'year', 'departmentOptions'));
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

        $budget = Budget::where(['year' => $year, 'month' => $month, 'department_id' => $departmentId])->updateOrCreate([
            'amount' => VND_to_number($request->input('value'))
        ], [
            'amount' => VND_to_number($request->input('value')),
            'year' => $year,
            'month' => $month,
            'department_id' => $departmentId
        ]);

        if ($budget) $budget->refresh();

        return ['success' => true];
    }
}
