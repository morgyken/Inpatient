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
        Schema::create('recurrent_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit_id')->unsigned();
            $table->integer('recurrent_charge_id')->unsigned();
            $table->string('status')->default('unpaid');
            $table->timestamps();

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
        Schema::dropIfExists('recurrent_charges');
    }
}
