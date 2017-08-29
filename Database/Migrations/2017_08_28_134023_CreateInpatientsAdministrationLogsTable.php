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
            $column->integer('prescription_id')->unsigned();
            $column->string('time');
            $column->string('am_pm');
            $column->integer('user')->unsigned();
            $column->timestamps();

            $column->foreign('prescription_id')
                    ->references('id')
                    ->on('evaluation_prescriptions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
