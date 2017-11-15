<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientRequestAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_request_admissions', function (Blueprint $table) {
            
            $table->increments('id');

            $table->integer('patient_id');

            $table->integer('visit_id');

            $table->integer('admission_type_id');

            $table->longText('reason');

            $table->decimal('authorized');

            $table->integer('authorized_by');

            $table->tinyInteger('cancelled');

            $table->timestamp('deleted_at');

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
        Schema::dropIfExists('inpatient_request_admissions');
    }
}
