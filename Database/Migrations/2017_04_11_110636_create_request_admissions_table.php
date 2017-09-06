<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_admissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('visit_id')->nullable();
            $table->longText('reason')->nullable();
            $table->timestamps();

            $table->foreign('visit_id')
                ->references('id')->on('evaluation_visits')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('patient_id')
                ->references('id')->on('reception_patients')
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
        Schema::dropIfExists('request_admissions');
    }
}
