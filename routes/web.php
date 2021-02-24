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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('employees')->name('employees.')->group(function() {
    Route::get('/', 'EmployeeController@index')->name('index');
    Route::get('/create', 'EmployeeController@create')->name('create');
    Route::get('/edit/{id}', 'EmployeeController@edit')->name('edit');
    Route::post('/store', 'EmployeeController@store')->name('store');
    Route::put('/update/{id}', 'EmployeeController@update')->name('update');
});

Route::prefix('working-days')->name('working_days.')->group(function() {
    Route::get('/', 'WorkingDaysController@index')->name('index');
});


Route::get('/home', 'HomeController@index')->name('home');
