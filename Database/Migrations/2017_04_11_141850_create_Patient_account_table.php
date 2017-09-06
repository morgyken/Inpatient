<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Patient_account', function (Blueprint $table) {
            $table->increments('id');
            $table->double('balance')->default(0.00);
            $table->unsignedInteger('patient_id');
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('id')
                ->on('reception_patients')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Patient_account');
    }
}
