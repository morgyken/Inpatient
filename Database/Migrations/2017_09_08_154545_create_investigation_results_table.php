<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestigationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_investigation_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investigation')->unsigned();
            $table->integer('user')->unsigned()->nullable();
            $table->longText('instructions')->nullable();
            $table->longText('results')->nullable()->nullable();
            $table->longText('comments')->nullable();
            $table->integer('file')->unsigned()->nullable();
            $table->integer('status')->default(0); //0-pending, verified-1, published-2, sent-3
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
        Schema::dropIfExists('inpatient_investigation_results');
    }
}
