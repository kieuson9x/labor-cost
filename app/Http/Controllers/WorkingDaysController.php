<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Overtime;
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

        return view('working_days.index', compact('workingDays', 'year'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $request->all();

        $fieldName = Overtime::MAPPING_OVERTIME_TYPE[$request->input('type')];

        return [];
    }
}
