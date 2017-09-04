<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->integer('ward_id')->unsigned();
            $table->integer('bed_id')->unsigned();
            $table->integer('bedposition_id')->unsigned();
            $table->double('cost')->default(0.00);
            $table->longText('reason')->nullable();
            $table->string('external_doctor')->nullable();
            $table->integer('visit_id')->nullable()->unsigned();
            //foreign keys
            $table->foreign('patient_id')
                ->references('id')
                ->on('reception_patients')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('bedposition_id')
                ->references('id')
                ->on('bed_position')
                ->onDelete('cascade')
                ->onUpdate('cascade');

    


            $table->foreign('visit_id')
                ->references('id')
                ->on('evaluation_visits')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('ward_id')
                ->references('id')
                ->on('wards')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('bed_id')
                ->references('id')
                ->on('beds')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('admissions');
    }
}
