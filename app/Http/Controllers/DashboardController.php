<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Product\Models\Product;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Overtime;
use App\Modules\Department\Models\BudgetPlan;
use App\Modules\Department\Models\Department;
use App\Modules\WorkingDay\Models\WorkingDay;
use App\Modules\Department\Models\ProductPlan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = (int) ($request->get('year') ?? Carbon::now()->year);
        $departmentOptions = Department::getDepartmentOptions();

        $data = array();

        $productPlans = ProductPlan::where(['year' => $year])
            ->select('product_id')
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) use ($year) {
                return ProductPlan::where(['product_id' => $item->product_id, 'year' => $year])->latest()->get();
            });

        $productOptions = Product::getProductOptions();
        $budgetData = $this->getBudgetData($year);
        $laborCostData = $this->getLaborCostData($year);

        return view('dashboard', compact('productPlans', 'productOptions', 'year', 'departmentOptions', 'laborCostData', 'budgetData'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $productPlanId)
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

        $data = $this->getLaborCostData($year, $productPlan->department->id);

        return $data;
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

        return redirect("/")->with('success', 'saved!');
    }

    public function getBudgetData($year)
    {
        $budgetData = array();

        $budgetData["Tổng"] = [
            'Luỹ kế theo kế hoạch' => 0,
            'Luỹ kế lương theo kế hoạch sản xuất' => 0,
            'Chi phí thực tế ERP' => 0,
            'Luỹ kế so sánh' => 0,
            'Vượt' => 0,
        ];

        for ($i = 1; $i <= 12; $i++) {
            $condition = ['year' => $year, 'month' => $i];
            $budgetData["Tháng {$i}"] = [
                'Luỹ kế theo kế hoạch' => 0,
                'Luỹ kế lương theo kế hoạch sản xuất' => 0,
                'Chi phí thực tế ERP' => 0,
                'Luỹ kế so sánh' => 0,
                'Vượt' => false
            ];

            Department::all()->each(function ($department) use (&$budgetData, $condition, $year, $i) {
                $budgetPlan = data_get($department->getBudgetPlan($year, $i), 'amount');
                $totalTimeNeeded = $department->getTotalNeededTimeByPlan($condition);
                $actualBudget = $department->getActualEmployeeCost($condition, $totalTimeNeeded);
                $budgetByAccounting = data_get($department->budgets()->where($condition)->latest()->first(), 'amount');
                $comparableBudget = $budgetByAccounting ? $budgetByAccounting : $actualBudget;

                $budgetData["Tháng {$i}"]['Luỹ kế theo kế hoạch'] += $budgetPlan;
                $budgetData["Tháng {$i}"]['Luỹ kế lương theo kế hoạch sản xuất'] += $actualBudget;
                $budgetData["Tháng {$i}"]['Chi phí thực tế ERP'] += $budgetByAccounting;
                $budgetData["Tháng {$i}"]['Luỹ kế so sánh'] += $comparableBudget;
            });

            $budgetData["Tổng"]['Luỹ kế theo kế hoạch'] += $budgetData["Tháng {$i}"]['Luỹ kế theo kế hoạch'];
            $budgetData["Tổng"]['Luỹ kế lương theo kế hoạch sản xuất'] += $budgetData["Tháng {$i}"]['Luỹ kế lương theo kế hoạch sản xuất'];
            $budgetData["Tổng"]['Chi phí thực tế ERP'] += $budgetData["Tháng {$i}"]['Chi phí thực tế ERP'];
            $budgetData["Tổng"]['Luỹ kế so sánh'] += $budgetData["Tháng {$i}"]['Luỹ kế so sánh'];

            data_set($budgetData, "Tháng {$i}.Vượt", data_get($budgetData, "Tháng {$i}.Luỹ kế so sánh") > data_get($budgetData, "Tháng {$i}.Luỹ kế theo kế hoạch"));
        }

        data_set($budgetData, 'Tổng.Vượt', data_get($budgetData, 'Tổng.Luỹ kế so sánh') > data_get($budgetData, 'Tổng.Luỹ kế theo kế hoạch'));

        return $budgetData;
    }

    public function getLaborCostData(int $year)
    {
        $laborCostData = array();
        $laborCostData['Tổng'] = [
            'Số nhân công có' => 0,
            'Số nhân công cần' => 0,
            'Vượt' => false
        ];

        for ($i = 1; $i <= 12; $i++) {
            $laborCostData["Tháng {$i}"] = [
                'Số nhân công có' => 0,
                'Số nhân công cần' => 0,
                'Vượt' => false
            ];

            $condition = ['year' => $year, 'month' => $i];

            Department::all()->each(function ($department) use (&$laborCostData, $condition, $year, $i) {
                $totalEmployees = $department->getTotalEmployees($condition);
                $totalEmployeesNeeded = $department->getTotalNeededEmployeeByPlan($condition);

                $laborCostData["Tháng {$i}"]['Số nhân công có'] += $totalEmployees;
                $laborCostData["Tháng {$i}"]['Số nhân công cần'] += $totalEmployeesNeeded;
            });

            $laborCostData['Tổng']['Số nhân công có'] += $laborCostData["Tháng {$i}"]['Số nhân công có'];
            $laborCostData['Tổng']['Số nhân công cần'] += $laborCostData["Tháng {$i}"]['Số nhân công cần'];

            data_set($laborCostData, "Tháng {$i}.Vượt", data_get($laborCostData, "Tháng {$i}.Số nhân công cần") > data_get($laborCostData, "Tháng {$i}.Số nhân công có"));
        }

        data_set($laborCostData, 'Tổng.Vượt', data_get($laborCostData, 'Tổng.Số nhân công cần') > data_get($laborCostData, 'Tổng.Số nhân công có'));

        return $laborCostData;
    }
}
