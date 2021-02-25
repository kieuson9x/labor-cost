<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Overtime;

class EmployeeOvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $employeeId)
    {
        $year = $request->get('year') ?? Carbon::now()->year;
        $employee = Employee::find($employeeId);

        $overtimes = $employee->overtimes()->where('year', $year)->orderBy('month')->get();
        return view('employees.overtime.index', compact('employeeId', 'overtimes', 'year', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $overtime = $employee->overtimes()->firstOrCreate([
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ]);

        $fieldName = Overtime::MAPPING_OVERTIME_TYPE[$request->input('type')];

        $overtime->update([
            "{$fieldName}" => $request->input('value')
        ]);

        $overtime->refresh();

        return [];
    }
}
