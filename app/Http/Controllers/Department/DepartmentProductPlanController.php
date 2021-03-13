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

        $laborCostData = $this->getLaborCostData($year, $departmentId);
        $budgetData = $this->getBudgetData($year, $departmentId);

        return view('product_plans.index', compact('productPlans', 'year', 'departmentId', 'departmentTitle', 'departmentOptions', 'productOptions', 'laborCostData', 'budgetData'));
    }

    public function getBudgetData($year, $departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $budgetData = array();

        $budgetData['Tổng'] = [
            'Luỹ kế theo kế hoạch' => 0,
            'Luỹ kế lương theo kế hoạch sản xuất' => 0,
            'Chi phí thực tế ERP' => 0,
            'Luỹ kế so sánh' => 0,
            'Vượt' => 0,
        ];

        for ($i = 1; $i <= 12; $i++) {
            $condition = ['year' => $year, 'month' => $i];
            $budgetPlan = data_get($department->getBudgetPlan($year, $i), 'amount');
            $totalTimeNeeded = $department->getTotalNeededTimeByPlan($condition);
            $actualBudget = $department->getActualEmployeeCost($condition, $totalTimeNeeded);
            $budgetByAccounting = data_get($department->budgets()->where($condition)->latest()->first(), 'amount');
            $comparableBudget = $budgetByAccounting ? $budgetByAccounting : $actualBudget;

            $budgetData['Tổng']['Luỹ kế theo kế hoạch'] += $budgetPlan;
            $budgetData['Tổng']['Luỹ kế lương theo kế hoạch sản xuất'] += $actualBudget;
            $budgetData['Tổng']['Chi phí thực tế ERP'] += $budgetByAccounting;
            $budgetData['Tổng']['Luỹ kế so sánh'] += $comparableBudget;


            $budgetData["Tháng {$i}"] = [
                'Luỹ kế theo kế hoạch' => $budgetPlan,
                'Luỹ kế lương theo kế hoạch sản xuất' => $actualBudget,
                'Chi phí thực tế ERP' => $budgetByAccounting,
                'Luỹ kế so sánh' => $comparableBudget,
                'Vượt' => $comparableBudget > $budgetPlan,
            ];
        }

        data_set($budgetData, 'Tổng.Vượt', data_get($budgetData, 'Tổng.Luỹ kế so sánh') > data_get($budgetData, 'Tổng.Luỹ kế theo kế hoạch'));

        return $budgetData;
    }

    public function getLaborCostData(int $year, int $departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $laborCostData = array();
        $laborCostData['Tổng'] = [
            'Số nhân công có' => 0,
            'Số nhân công cần' => 0,
            'Vượt' => false
        ];

        for ($i = 1; $i <= 12; $i++) {
            $condition = ['year' => $year, 'month' => $i];
            $totalEmployeesNeeded = $department->getTotalNeededEmployeeByPlan($condition);
            $totalEmployees = $department->getTotalEmployees($condition);

            $laborCostData['Tổng']['Số nhân công có'] += $totalEmployees;
            $laborCostData['Tổng']['Số nhân công cần'] += $totalEmployeesNeeded;

            $laborCostData["Tháng {$i}"] = [
                'Số nhân công có' => $totalEmployees,
                'Số nhân công cần' => $totalEmployeesNeeded,
                'Vượt' => round($totalEmployeesNeeded) > round($totalEmployees)
            ];
        }

        data_set($laborCostData, 'Tổng.Vượt', data_get($laborCostData, 'Tổng.Số nhân công cần') > data_get($laborCostData, 'Tổng.Số nhân công có'));

        return $laborCostData;
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
