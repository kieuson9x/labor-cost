<?php

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Department\Models\BudgetPlan;
use App\Modules\Department\Models\Department;

class BudgetPlanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('data/budget_plans.csv');;
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            $department = Department::where('department_code', $record['Mã bộ phận'])->first();
            $departmentId = data_get($department, 'id');
            $year = $record['Năm'];


            for ($i = 1; $i <= 12; $i++) {
                $monthHeaderName = 'Ngân sách kế hoạch tháng ' . sprintf('%02d', $i);
                $amount =  $amount = floatval(str_replace('.', ',', str_replace(',', '', $record[$monthHeaderName])));
                BudgetPlan::updateOrCreate([
                    'department_id' => $departmentId,
                    'year' => $year,
                    'month' => $i
                ], [
                    'month' => $i,
                    'year' => $year,
                    'department_id' =>  $departmentId,
                    'amount' => (float) $amount
                ]);
            }
        }
    }
}
