<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestDischargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_discharges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('visit_id')->nullable();
            $table->unsignedInteger('doctor_id')->nullable();
            $table->string('reason')->nullable();
            $table->string('status')->default('unconfirmed');
            $table->timestamps();

            $table->foreign('admission_id')
            ->references('id')
            ->on('admissions')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('doctor_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('visit_id')
            ->references('id')
            ->on('evaluation_visits')
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
        Schema::dropIfExists('request_discharges');
    }
}
