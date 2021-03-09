<?php

namespace App\Http\Controllers\Department;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Product\Models\Product;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\BudgetPlan;
use App\Modules\Department\Models\Department;
use App\Modules\WorkingDay\Models\WorkingDay;
use App\Modules\Department\Models\ProductPlan;

class DepartmentProductPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $departmentId)
    {
        $year = $request->get('year') ?? Carbon::now()->year;

        $productPlans = ProductPlan::where(['year' => $year, 'department_id' => $departmentId])
            ->select('product_id')
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) use ($year, $departmentId) {
                return ProductPlan::where(['product_id' => $item->product_id, 'year' => $year, 'department_id' => $departmentId])->latest()->get();
            });

        $departmentOptions = Department::getDepartmentOptions();
        $departmentTitle = collect($departmentOptions)->filter(function ($item) use ($departmentId) {
            return $item['value'] === $departmentId;
        })->first()['title'] ?? '-';
        $productOptions = Product::getProductOptions();

        $data = $this->getLaborCostData($year, $departmentId);

        $numberOfEmployeeData = $data['numberOfEmployeeData'];
        $totalNeededTimeData = $data['totalNeededTimeData'];
        $totalNeededEmployeeData = $data['totalNeededEmployeeData'];

        return view('product_plans.index', compact('productPlans', 'year', 'departmentId', 'departmentTitle', 'departmentOptions', 'productOptions', 'numberOfEmployeeData', 'totalNeededTimeData', 'totalNeededEmployeeData'));
    }

    public function getLaborCostData(int $year, int $departmentId)
    {
        // Get report data
        $department = Department::find($departmentId) ?? Department::first();
        $numberOfEmployeeData = array();
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate($year, $i)->startOfMonth();
            $numberOfEmployee = $department->employees()->whereHas('histories', function ($query) use ($date) {
                return $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
            })->count();

            $numberOfEmployeeData["Tháng {$i}"] = [$numberOfEmployee];
        }

        $totalNeededTimeData = array();
        $totalNeededEmployeeData = array();
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate($year, $i)->startOfMonth();
            $sum = 0;
            $productPlanTime = $department->productPlans()->where('month', $i)->where('year', $year)->each(function ($item) use (&$sum) {
                $sum += $item->product->rate * $item->quantity;
            });

            $workingDays = WorkingDay::where(['month' => $i, 'year' => $year])->first()->working_days ?? WorkingDay::getNormalWorkingDays($year, $i);

            $totalNeededTimeData["Tháng {$i}"] = $sum;
            $totalNeededEmployeeData["Tháng {$i}"] = $sum / (8 * $workingDays);
        }

        return [
            'numberOfEmployeeData' => $numberOfEmployeeData,
            'totalNeededTimeData' => $totalNeededTimeData,
            'totalNeededEmployeeData' => $totalNeededEmployeeData,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $departmentId)
    {
        $productPlanId = $request->input('product_plan_id');
        $year = $request->input('year');
        $month = $request->input('month');

        $productPlan = ProductPlan::find((int) $productPlanId);

        if ($productPlan) {
            $productPlan->update([
                'quantity' => $request->input('value')
            ]);
        }

        $productPlan->refresh();

        $data = $this->getLaborCostData($year, $departmentId);

        return $data;
    }

    // View : Create
    public function create(Request $request)
    {
        $departmentOptions = Department::getDepartmentOptions();

        return view('product_plans.create', compact('departmentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $months = $request->input('months', []);

        foreach ($months as $month) {
            ProductPlan::updateOrCreate(
                [
                    'department_id'     => $request->input('department_id'),
                    'product_id'        => $request->input('product_id'),
                    'month'             => $month,
                    'year'              => $request->input('year')
                ],
                [
                    'department_id'     => $request->input('department_id'),
                    'product_id'        => $request->input('product_id'),
                    'month'             => $month,
                    'year'              => $request->input('year'),
                    'quantity'          => $request->input('quantity')
                ]
            );
        }

        return redirect("/departments/{$request->input('department_id')}/product-plans")->with('success', 'Employee saved!');
    }
}
