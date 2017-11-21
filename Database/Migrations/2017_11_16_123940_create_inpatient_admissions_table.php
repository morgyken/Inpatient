<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_admissions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('patient_id')->unsigned();

            $table->integer('doctor_id')->nullable();

            $table->integer('ward_id')->unsigned();

            $table->integer('bed_id')->unsigned();

            $table->decimal('cost')->nullable();

            $table->longText('reason')->nullable();

            $table->string('external_doctor', 255)->nullable();

            $table->integer('visit_id')->unsigned();

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
        Schema::dropIfExists('inpatient_admissions');
    }
}
