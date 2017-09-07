<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemperaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_temperatures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('respiration')->nullable();
            $table->integer('pulse')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('bowels')->nullable();
            $table->integer('urine')->nullable();
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('patient_id');
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
        Schema::dropIfExists('inpatient_temperatures');
    }
}
