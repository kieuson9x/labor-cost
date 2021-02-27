<?php

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Product\Models\Product;
use App\Modules\CostFactor\Models\CostFactor;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('data/products.csv');;
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            $costFactorId = CostFactor::where('cost_factor_code', $record["Mã ytcp"])->first()->id ?? null;

            Product::updateOrCreate([
                'product_code' => $record['Sản phẩm']
            ], [
                'product_code' => $record['Sản phẩm'],
                'name'            => $record['Tên sản phẩm'],
                'rate'          => $record['Hệ số'],
                'cost_factor_id' => $costFactorId
            ]);
        }
    }
}
