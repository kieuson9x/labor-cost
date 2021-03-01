<?php

use Carbon\Carbon;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Employee\Models\Salary;
use App\Modules\Employee\Models\Employee;
use App\Modules\Department\Models\Department;
use App\Modules\Employee\Models\EmployeeHistory;

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

            Salary::firstOrCreate([
                'employee_id'       => $employee->id,
                'amount'            => $amount,
            ], [
                'employee_id'       => $employee->id,
                'amount'            => $amount,
                'start_date'        => Carbon::createFromDate(2021, 1, 1)->format('Y-m-d'),
                'end_date'          => Carbon::createFromDate(2021, 12, 31)->format('Y-m-d')
            ]);

            EmployeeHistory::firstOrCreate([
                'employee_id'       => $employee->id,
            ], [
                'employee_id'       => $employee->id,
                'start_date'        => Carbon::createFromDate(2021, 1, 1)->format('Y-m-d'),
                'end_date'          => Carbon::createFromDate(2021, 12, 31)->format('Y-m-d'),
            ]);
        }
    }
}
