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
            $table->integer('month');
            $table->integer('year');

            $table->float('weekdays')->default(0);
            $table->float('sunday')->default(0);
            $table->float('holiday')->default(0);
            $table->float('night')->default(0);
            $table->float('weekdays_night')->default(0);
            $table->float('sunday_night')->default(0);
            $table->float('holiday_night')->default(0);

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
