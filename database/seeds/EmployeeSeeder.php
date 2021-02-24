<?php

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Employee\Models\Employee;
use App\Modules\Department\Models\Department;

class EmployeeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('data/sample_employees.csv');;
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();



        foreach ($records as $record) {
            Employee::updateOrCreate([
                'employee_code' => $record['Mã NV']
            ], [
                'employee_code' => $record['Mã NV'],
                'full_name'     => $record['Họ tên nhân viên'],
                'department_id' => Department::where('department_code', $record['Bộ phận'])->first()->id
            ]);
        }
    }
}
