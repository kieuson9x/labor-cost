<?php

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\CostFactor\Models\CostFactor;

class CostFactorSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('data/cost_factors.csv');;
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            CostFactor::updateOrCreate([
                'cost_factor_code' => $record['Mã ytcp']
            ], [
                'cost_factor_code' => $record['Mã ytcp'],
                'name'            => $record['Tên yếu tố'],
            ]);
        }
    }
}
