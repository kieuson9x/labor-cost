<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Department\Models\Department;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        return view('employees.index', compact('employees'));
    }

    public function searchByName(Request $request)
    {
        $keyword = $request->input('keyword');
        $employees = Employee::where('name', 'LIKE', "%$keyword%")->get()->map(function ($employee) {
            return [
                'id' => $employee->id,
                'full_name' => $employee->full_name,
                'department_name' => $employee->department->name ?? '',
                'department_id' => $employee->department_id
            ];
        });
        return response()->json($employees);
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

        $now = Carbon::now();

        $salary = $employee->salaries()->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->latest()
            ->first();

        if ($salary) {
            $salary->update([
                'amount' => $request->get('amount')
            ]);
        } else {
            $employee->salaries()->create([
                'amount'        => $request->get('amount'),
                'start_date'    => Carbon::createFromDate($now->year, 1, 1)->format('Y-m-d'),
                'end_date'    => Carbon::createFromDate($now->year, 12, 31)->format('Y-m-d'),
            ]);
        }

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
