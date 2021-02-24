<?php

use Carbon\Carbon;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\WorkingDay\Models\WorkingDay;

class WorkingDaySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('data/workingDays.csv');;
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $headers = $csv->getHeader();

        $data = [];

        foreach ($records as $record) {
            array_push($data, $record);
        }

        $collection = collect($data);
        $grouped = $collection->groupBy('Năm');

        foreach ($grouped as $year => $group) {
            foreach ($headers as $header) {
                if ($header === 'Năm' || $header === 'Nội dung') {
                    continue;
                }

                $month =  str_ireplace('Tháng ', '', $header);

                $daysInMonth = Carbon::createFromDate($year, $month)->startOfMonth()->daysInMonth;

                $annualDaysOff = (int) (data_get($group, "2.${header}"));
                $saturdayAfternoonDayOff = (int) data_get($group, "3.${header}");
                $holidays = (int) data_get($group, "4.${header}");
                WorkingDay::updateOrCreate([
                    'year' => $year,
                    'month' => $month
                ], [
                    'annual_days_off' => $annualDaysOff,
                    'saturday_afternoon_day_off' => $saturdayAfternoonDayOff,
                    'holiday' => $holidays,
                    'working_days' => $daysInMonth - $annualDaysOff - $saturdayAfternoonDayOff * 0.5 - $holidays
                ]);
            }
        }
    }
}
