<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();

            $table->integer('employee_id');
            $table->date('date');

            $table->integer('weekdays')->default(0);
            $table->integer('sunday')->default(0);
            $table->integer('holiday')->default(0);
            $table->integer('night')->default(0);
            $table->integer('weekdays_night')->default(0);
            $table->integer('sunday_night')->default(0);
            $table->integer('holiday_night')->default(0);

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
        Schema::dropIfExists('overtimes');
    }
}
