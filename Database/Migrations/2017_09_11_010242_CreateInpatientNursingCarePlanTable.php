<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientNursingCarePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('inpatient_nursing_care_plan', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('admission_id');
            $column->unsignedInteger('visit_id');
            $column->unsignedInteger('user_id');
            $column->longText('diagnosis');
            $column->longText('expected_outcome');
            $column->longText('intervention');
            $column->longText('reasons');
            $column->longText('evaluation');
            $column->date('date_recorded');
            $column->string('time_recorded');
            $column->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inpatient_nursing_care_plan');
    }
}
