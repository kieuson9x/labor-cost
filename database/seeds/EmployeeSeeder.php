<?php

use Carbon\Carbon;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Employee\Models\Salary;
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
            $department = Department::where('department_code', $record['Bộ phận'])->first();
            $employee = Employee::firstOrCreate([
                'employee_code' => $record['Mã NV']
            ], [
                'employee_code' => $record['Mã NV'],
                'full_name'     => $record['Họ tên nhân viên'],
                'department_id' => $department->id ?? null
            ]);


            $amount = floatval(str_replace('.', ',', str_replace(',', '', $record['Lương chính'])));

            Salary::updateOrCreate([
                'employee_id' => $employee->id,
            ], [
                'employee_id'    => $employee->id,
                'amount'        => $amount,
                'date'          => Carbon::now()->startOfMonth()->toDateTimeLocalString()
            ]);
        }
    }
}
