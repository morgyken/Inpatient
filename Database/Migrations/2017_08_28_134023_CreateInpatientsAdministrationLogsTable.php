<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientsAdministrationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_administration_logs', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('admission_id');
            $column->unsignedInteger('visit_id');
            $column->unsignedInteger('prescription_id');
            $column->string('time');
            $column->unsignedInteger('user');
            $column->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('inpatient_administration_logs');
    }
}
