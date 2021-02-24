<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Observers\EmployeeObserver;

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
    }
}
