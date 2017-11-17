<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_charges', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->decimal('cost');

            $table->integer('ward_id');

            $table->enum('type', ['recurring', 'once']);

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
        Schema::dropIfExists('inpatient_charges');
    }
}
