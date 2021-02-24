<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\Department;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::all();

        return view('overtimes.index', compact('employees'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $employeeId)
    {
        return view('overtimes.create', compact('employeeId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'month'             => 'required',
            'year'              => 'required',
            'employee_id'        => 'required'
        ]);

        $requestData = $request->only([
            'month',
            'year',
            "weekdays",
            "sunday",
            "holiday",
            "night",
            "weekdays_night",
            "sunday_night",
            "holiday_night",
            "employee_id"
        ]);

        $overtime = new Overtime($requestData);

        $overtime->save();
        $overtime->refresh();

        return redirect('/employees')->with('success', 'Đăng ký thành công!');
    }
}
