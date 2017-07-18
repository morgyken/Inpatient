<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionproceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_procedures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admission_id')->unsigned(); //fk to admissions
            $table->integer('admission_category_id')->unsigned();
            $table->json('notes');
            $table->integer('performed_by'); //Auth::user()->id;
            $table->timestamps();
        });

        Schema::table('admission_procedures', function(Blueprint $table){
            $table->foreign('admission_category_id')->references('id')->on('admission_procedure_category');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_procedures');
    }
}
