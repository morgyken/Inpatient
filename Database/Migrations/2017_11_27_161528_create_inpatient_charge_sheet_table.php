<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientChargeSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_charge_sheet', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('visit_id');

            $table->integer('prescription_id')->nullable();

            $table->integer('consumable_id')->nullable();

            $table->integer('investigation_id')->comment('charges made on investigations')->nullable();

            $table->integer('procedure_id')->comment('charges made on procedures')->nullable();

            $table->integer('charge_id')->comment('charges made id')->nullable();

            $table->integer('ward_id')->comment('charges made on ward')->nullable();

            $table->boolean('paid')->default(0);

            $table->decimal('price');

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
        Schema::dropIfExists('inpatient_charge_sheet');
    }
}
