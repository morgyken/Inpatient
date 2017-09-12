<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientVitalsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_vitals', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('visit_id');
            $column->unsignedInteger('admission_id');
            $column->double('weight', 10, 2)->default(0);
            $column->double('height', 10, 2)->default(0);
            $column->string('bp_systolic')->default(0);
            $column->string('bp_diastolic')->default(0);
            $column->string('pulse')->default(55);
            $column->string('respiration')->default(12);
            $column->string('temperature')->default(30);
            $column->string('temperature_location')->default("Oral");
            $column->double('oxygen', 10, 2)->default(0);
            $column->double('waist', 10, 2)->default(0);
            $column->double('hip', 10, 2)->default(0);
            $column->string('blood_sugar')->default(0);
            $column->string('blood_sugar_units')->default('mmol/L');
            $column->string('allergies')->nullable();
            $column->longText('chronic_illnesses')->nullable();
            $column->unsignedInteger('user_id');
            $column->date('date_recorded');
            $column->string('time_recorded');
            $column->timestamps();

            $column->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('visit_id')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('admission_id')
                    ->references('id')
                    ->on('admissions')
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
        Schema::drop('inpatient_vitals');
    }
}
