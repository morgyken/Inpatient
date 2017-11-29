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

            $table->integer('dispensing_id')->nullable()->comment('rel:inventory_evaluation_dispensing');

            $table->integer('consumable_id')->nullable()->comment('rel:inpatient_consumables');

            $table->integer('investigation_id')->nullable()->comment('rel:evaluation_investigations');

            $table->integer('charge_id')->nullable()->comment('rel:inpatient_charges');

            $table->integer('ward_id')->nullable()->comment('rel:inpatient_wards');

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
