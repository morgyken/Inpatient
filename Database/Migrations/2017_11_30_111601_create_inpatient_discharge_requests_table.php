<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientDischargeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_discharge_requests', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('visit_id');

            $table->integer('discharge_type_id');

            $table->longText('principal');

            $table->longText('other');

            $table->longText('complains');

            $table->longText('investigations');

            $table->longText('conditions');

            $table->longText('medication');

            $table->softDeletes();

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
        Schema::dropIfExists('discharge_requests');
    }
}
