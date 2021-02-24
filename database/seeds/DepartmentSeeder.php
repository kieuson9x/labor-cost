<?php

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Department\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('data/departments.csv');;
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            Department::updateOrCreate([
                'department_code' => $record['department_code']
            ],[
                'department_code' => $record['department_code'],
                'name'            => $record['name']
            ]);
        }
    }
}
