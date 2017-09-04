<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDischargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit_id')->unsigned();
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->string('type');
            $table->string('DischargeNote');
            $table->string('dateofdeath')->nullable();
            $table->string('timeofdeath')->nullable();

            $table->foreign('visit_id')
            ->references('id')->on('evaluation_visits')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('doctor_id')
            ->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('discharges');
    }
}
