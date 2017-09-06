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
        Schema::create('dischargeNotes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('doctor_id')->nullable();
            $table->unsignedInteger('visit_id')->nullable();
            $table->longText('summary_note')->nullable();
            $table->longText('case_note')->nullable();
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
