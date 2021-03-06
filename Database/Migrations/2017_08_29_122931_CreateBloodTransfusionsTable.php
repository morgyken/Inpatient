<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloodTransfusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_blood_transfusion', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('admission_id');
            $column->unsignedInteger('visit_id');
            $column->unsignedInteger('user_id');
            $column->integer('bp_systolic')->nullable();
            $column->integer('bp_diastolic')->nullable();
            $column->integer('temperature')->nullable();
            $column->integer('respiration')->nullable();
            $column->longText('remarks')->nullable();
            $column->date('date_recorded');
            $column->string('time_recorded');
            $column->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('inpatient_blood_transfusion');
    }
}
