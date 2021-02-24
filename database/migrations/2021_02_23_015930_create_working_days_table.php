<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_days', function (Blueprint $table) {
            $table->id();

            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('annual_days_off')->default(0);
            $table->integer('saturday_afternoon_day_off')->default(0);
            $table->integer('holiday')->default(0);
            $table->double('working_days')->default(0);

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
        Schema::dropIfExists('working_days');
    }
}
