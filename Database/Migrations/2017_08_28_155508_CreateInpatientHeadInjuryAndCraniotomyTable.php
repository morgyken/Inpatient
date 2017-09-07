<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientHeadInjuryAndCraniotomyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_headinjury_and_craniotomy', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('admission_id');
            $column->unsignedInteger('visit_id');
            $column->unsignedInteger('user_id');
            $column->string('bp_systolic')->nullable();
            $column->string('bp_diastolic')->nullable();
            $column->string('pulse')->nullable();
            $column->string('respiration')->nullable();
            $column->string('temperature')->nullable();
            $column->text('conscious_status');
            $column->text('pupil_status');
            $column->timestamps();

           
            $column->foreign('admission_id')->references('id')->on('admissions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('visit_id')->references('id')->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user_id')->references('id')->on('users')
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
        Schema::drop('inpatient_headinjury_and_craniotomy');
    }
}
