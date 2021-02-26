<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Employee\Models\Employee;
use App\Modules\WorkingDay\Models\WorkingDay;
use App\Modules\Employee\Observers\EmployeeObserver;
use App\Modules\WorkingDay\Observers\WorkingDayObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Employee::observe(EmployeeObserver::class);
        WorkingDay::observe(WorkingDayObserver::class);
    }
}
