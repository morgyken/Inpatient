<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDischargeNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_discharge_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('doctor_id')->nullable();
            $table->unsignedInteger('visit_id')->nullable();
            $table->longText('case_note')->nullable();
            $table->longText('principal_diagnosis')->nullable();
            $table->longText('other_diagnosis')->nullable();
            $table->longText('admission_complaints')->nullable();
            $table->longText('investigations_courses')->nullable();
            $table->longText('discharge_condition')->nullable();
            $table->longText('discharge_medications')->nullable(); // Serialized array of prescription ids
            $table->timestamps();
           
            $table->foreign('admission_id')->references('id')
            ->on('admissions')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('doctor_id')->references('id')
            ->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('visit_id')->references('id')
            ->on('evaluation_visits')->onDelete('cascade')->onUpdate('cascade');
   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dischargeNotes');
    }
}
