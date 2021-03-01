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
use App\Modules\Department\Models\ProductPlan;

class DepartmentProductPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departmentId = $request->input('department_id', 1);
        $year = $request->get('year') ?? Carbon::now()->year;

        $productPlans = ProductPlan::where(['year' => $year, 'department_id' => $departmentId])
            ->select('product_id')
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) use ($year, $departmentId) {
                return ProductPlan::where(['product_id' => $item->product_id, 'year' => $year, 'department_id' => $departmentId])->latest()->get();
            });

        $departmentOptions = Department::getDepartmentOptions();
        $productOptions = Product::getProductOptions();

        return view('product_plans.index', compact('productPlans', 'year', 'departmentId', 'departmentOptions', 'productOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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

        return ['success' => true];
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

        return redirect('/departments/product-plans')->with('success', 'Employee saved!');
    }
}
