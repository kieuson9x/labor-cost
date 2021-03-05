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
        $daysInMonths = [];
        $carbon = Carbon::createFromDate($year);

        for ($i = 1; $i <= 12; $i++) {
            $daysInMonth = $carbon->month($i)->daysInMonth;
            $daysInMonths[] = $daysInMonth;
        }

        return view('working_days.index', compact('workingDays', 'year', 'daysInMonths'));
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
        $fieldName = WorkingDay::MAPPING_TYPE[$request->input('type')];

        $workingDay = WorkingDay::firstOrCreate([
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ]);

        $workingDay->update([
            "{$fieldName}" => $request->input('value')
        ]);

        $workingDay->refresh();

        return [];
    }
}
