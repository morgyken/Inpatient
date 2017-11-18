<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientInsuranceMaximumAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_insurance_maximum_amounts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('admission_request_id');

            $table->integer('scheme_id');

            $table->decimal('maximum_amount');

            $table->longText('authorization_letter_url');

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
        Schema::dropIfExists('');
    }
}
