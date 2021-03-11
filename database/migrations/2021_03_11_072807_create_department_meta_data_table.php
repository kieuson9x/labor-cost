<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentMetaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_meta_data', function (Blueprint $table) {
            $table->id();

            $table->integer('department_id');
            $table->double('average_salary')->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->double('working_hours_per_day')->nullable();
            $table->double('working_days')->nullable();
            $table->double('week_days_overtime_hours')->nullable();
            $table->double('total_working_hours_per_month')->nullable();

            $table->integer('month');
            $table->integer('year');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_meta_data');
    }
}
