<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablesToInpatientVitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('inpatient_vitals', function (Blueprint $column) {
            $column->float('weight', 10, 2)->default(0)->nullable()->change();
            $column->float('height', 10, 2)->default(0)->nullable()->change();
            $column->float('waist', 10, 2)->default(0)->nullable()->change();
            $column->float('hip', 10, 2)->default(0)->nullable()->change();
            $column->string('blood_sugar')->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
