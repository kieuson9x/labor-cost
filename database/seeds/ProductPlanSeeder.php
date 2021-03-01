<?php

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Modules\Product\Models\Product;
use App\Modules\Department\Models\Department;
use App\Modules\Department\Models\ProductPlan;

class ProductPlanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('data/product_plans.csv');;
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            $productId = Product::where('product_code', $record['Mã hàng'])->first()->id ?? null;

            $departmentId = Department::where('department_code', $record['Mã Bộ phận'])->first()->id ?? null;

            if (is_null($productId)) {
                Log::info("{$record['Mã hàng']}" . "của phòng ban {$record['Mã Bộ phận']}" . "đang không tồn tại trong bảng product");
                continue;
            }

            $year = $record['Năm'];

            for ($i = 1; $i <= 12; $i++) {
                $monthHeaderName = 'KH tháng ' . sprintf('%02d', $i);
                $quantity = floatval(str_replace('.', ',', str_replace(',', '', $record[$monthHeaderName])));
                ProductPlan::updateOrCreate([
                    'department_id' => $departmentId,
                    'product_id' => $productId,
                    'year' => $year,
                    'month' => $i
                ], [
                    'product_id' => $productId,
                    'month' => $i,
                    'year' => $year,
                    'department_id' =>  $departmentId,
                    'quantity' => (int) $quantity
                ]);
            }
        }
    }
}
