<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_investigations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visit');
            $table->string('type')->default('diagnosis');
            $table->unsignedInteger('procedure');
            $table->double('price', 10, 2);
            $table->integer('user')->unsigned()->nullable();
            $table->longText('instructions')->nullable();
            $table->boolean('ordered')->default(false);
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
        Schema::dropIfExists('inpatient_investigations');
    }
}
