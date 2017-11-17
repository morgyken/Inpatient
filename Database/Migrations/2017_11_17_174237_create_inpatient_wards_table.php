<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientWardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_wards', function (Blueprint $table) {
            $table->increments('id');

            $table->string('number');

            $table->string('name');

            $table->enum('gender', ['male', 'female', 'other'])->default('male');

            $table->enum('age_group', ['adult', 'children'])->default('adult');

            $table->decimal('insurance_cost');

            $table->decimal('cash_cost');
            
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
        Schema::dropIfExists('inpatient_wards');
    }
}
