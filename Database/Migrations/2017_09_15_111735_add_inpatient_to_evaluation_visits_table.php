<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInpatientToEvaluationVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_visits', function (Blueprint $table) {
            try{
                $table->boolean('inpatient')->default(0)->after('status');
            }catch (\Exception $e){

            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_visits', function (Blueprint $table) {

        });
    }
}
