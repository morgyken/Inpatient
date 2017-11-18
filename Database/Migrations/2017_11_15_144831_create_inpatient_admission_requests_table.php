<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientAdmissionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_admission_requests', function (Blueprint $table) {
            
            $table->increments('id');

            $table->integer('patient_id');

            $table->integer('visit_id');

            $table->integer('admission_type_id');

            $table->longText('reason');

            $table->decimal('authorized');

            $table->integer('authorized_by');

            $table->tinyInteger('cancelled');

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
        Schema::dropIfExists('inpatient_admission_requests');
    }
}
