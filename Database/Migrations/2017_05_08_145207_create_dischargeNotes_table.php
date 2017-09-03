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
            $table->longText('summary_note')->nullable();
            $table->longText('case_note')->nullable();
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->integer('visit_id')->unsigned()->nullable();


            $table->foreign('doctor_id')->references('id')
            ->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('visit_id')->references('id')
            ->on('evaluation_visits')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('dischargeNotes');
    }
}
