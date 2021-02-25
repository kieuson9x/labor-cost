<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $year = $request->get('year') ?? Carbon::now()->year;

        return view('reports.salary', compact('year'));
    }
}
