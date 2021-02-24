<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
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
}
