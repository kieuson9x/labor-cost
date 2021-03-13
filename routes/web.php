<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::put('/product-plans/{productPlanId}', 'DashboardController@update')->name('dashboard.product_plan.update');
Route::post('/product-plans', 'DashboardController@store')->name('dashboard.product_plan.store');

Route::namespace('Employee')->prefix('employees')->name('employees.')->group(function () {
    Route::get('/', 'EmployeeController@index')->name('index');
    Route::get('/create', 'EmployeeController@create')->name('create');
    Route::get('/edit/{id}', 'EmployeeController@edit')->name('edit');
    Route::post('/store', 'EmployeeController@store')->name('store');
    Route::put('/update/{id}', 'EmployeeController@update')->name('update');
    Route::get('/search', 'EmployeeController@searchByName')->name('search');

    Route::get('/{employeeId}/overtimes', 'EmployeeOvertimeController@index')->name('overtimes.index');
    Route::put('/{employeeId}/overtimes', 'EmployeeOvertimeController@update')->name('overtimes.update');
});

Route::prefix('working-days')->name('working_days.')->group(function () {
    Route::get('/', 'WorkingDaysController@index')->name('index');
    Route::put('/', 'WorkingDaysController@update')->name('update');
});

Route::namespace('Report')->prefix('reports')->name('reports.')->group(function () {
    Route::get('/salary', 'DepartmentSalaryReportController@salary')->name('salary');
    Route::get('/labor-cost', 'DepartmentLaborCostController@index')->name('labor-cost');
});

Route::namespace('Department')->prefix('departments')->name('departments.')->group(function () {
    Route::get('/', 'DepartmentController@index')->name('index');
    Route::get('/budget-plans', 'DepartmentBudgetPlanController@index')->name('budget_plans.index');
    Route::put('/budget-plans', 'DepartmentBudgetPlanController@update')->name('budget_plans.update');

    Route::get('/{departmentId}/product-plans', 'DepartmentProductPlanController@index')->name('product_plans.index');
    Route::put('/{departmentId}/product-plans', 'DepartmentProductPlanController@update')->name('product_plans.update');
    Route::get('/{departmentId}/product-plans/getLaborCostData', 'DepartmentProductPlanController@getLaborCostData')->name('product_plans.getLaborCostData');

    Route::get('/{departmentId}/product-plans/create', 'DepartmentProductPlanController@create')->name('product_plans.create');
    Route::post('/{departmentId}/product-plans/store', 'DepartmentProductPlanController@store')->name('product_plans.store');

    Route::get('/budgets', 'DepartmentBudgetController@index')->name('budgets.index');
    Route::put('/budgets', 'DepartmentBudgetController@update')->name('budgets.update');
    Route::get('/budgets/create', 'DepartmentBudgetController@create')->name('budgets.create');
    Route::post('/budgets/store', 'DepartmentBudgetController@store')->name('budgets.store');

    Route::get('/{departmentId}', 'DepartmentController@show')->name('show');
    Route::put('/{departmentId}/update', 'DepartmentController@update')->name('update');
    Route::get('/{departmentId}/getBudgetData', 'DepartmentController@getBudgetData')->name('getBudgetData');
    Route::get('/{departmentId}/getLaborData', 'DepartmentController@getLaborData')->name('getLaborData');
});

Route::namespace('Product')->prefix('products')->name('products.')->group(function () {
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('/create', 'ProductController@create')->name('create');
    Route::get('/edit/{id}', 'ProductController@edit')->name('edit');
    Route::post('/store', 'ProductController@store')->name('store');
    Route::put('/update/{id}', 'ProductController@update')->name('update');
});
