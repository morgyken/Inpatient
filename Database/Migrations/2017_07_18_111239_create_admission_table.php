<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('ward_id')->unsigned();
            $table->integer('bed_id')->unsigned();
            $table->string('ip_number')->unsigned();
            $table->integer('admitted_by')->unisgned();
            $table->json('admission_notes')->unsigned();
            $table->timestamp('admitted_at');
            $table->timestamps();
        });

        Schema::table('admission', function(Blueprint $table){
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('ward_id')->references('id')->on('wards');
            $table->foreign('bed_id')->references('id')->on('beds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission');
    }
}
