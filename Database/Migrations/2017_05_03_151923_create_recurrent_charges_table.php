<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecurrentChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_recurrent_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('visit_id');
            $table->unsignedInteger('recurrent_charge_id');
            $table->string('status')->default('unpaid');
            $table->timestamps();

            $table->foreign('admission_id')
                  ->references('id')
                  ->on('admissions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');   

            $table->foreign('visit_id')
                  ->references('id')
                  ->on('evaluation_visits')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');   

            $table->foreign('recurrent_charge_id')
                  ->references('id')
                  ->on('nursing_charges')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inpatient_recurrent_charges');
    }
}
