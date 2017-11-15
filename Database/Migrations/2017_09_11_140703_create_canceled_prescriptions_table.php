<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanceledPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_canceled_prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('visit_id');
            $table->string('drug');
            $table->integer('take');
            $table->integer('whereto');
            $table->integer('method');
            $table->integer('duration');
            $table->boolean('allow_substitution')->default(false);
            $table->unsignedInteger('time_measure')->default(1); 
            $table->longText('reason');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('inpatient_canceled_prescriptions');
    }
}
