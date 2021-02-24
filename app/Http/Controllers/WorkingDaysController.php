<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Employee\Models\Employee;
use App\Modules\Department\Models\Department;
use App\Modules\WorkingDay\Models\WorkingDay;

class WorkingDaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->get('year') ?? Carbon::now()->year;

        $workingDays = WorkingDay::where('year', $year)->orderBy('month')->get();

        return view('working_days.index', compact('workingDays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departmentOptions = Department::getDepartmentOptions();

        return view('employees.create', compact('departmentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'full_name'         => 'required',
            'department_id'     => 'required'
        ]);

        $employee = new Employee([
            'full_name' => $request->get('full_name'),
            'department_id' => $request->get('department_id'),
        ]);

        $employee->save();
        $employee->refresh();

        return redirect('/employees')->with('success', 'Employee saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $departmentOptions = Department::getDepartmentOptions();
        return view('employees.edit', compact('employee', 'departmentOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        $employee->full_name =  $request->get('full_name');
        $employee->department_id = $request->get('department_id');
        $employee->save();
        $employee->refresh();

        return redirect('/employees')->with('success', 'Employee updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
