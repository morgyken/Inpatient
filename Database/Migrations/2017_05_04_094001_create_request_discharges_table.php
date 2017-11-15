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
        Schema::create('inpatient_request_discharges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('visit_id')->nullable();
            $table->unsignedInteger('doctor_id')->nullable();
            $table->string('reason')->nullable();
            $table->string('status')->default('unconfirmed');
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
        Schema::dropIfExists('inpatient_request_discharges');
    }
}
