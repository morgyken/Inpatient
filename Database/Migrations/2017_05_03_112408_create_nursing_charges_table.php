<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNursingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nursing_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('cost',2)->default(0.00);
            $table->integer('ward_id')->unsigned()->nullable();
            $table->enum('type',['nursing','admission']);
            //foreign keys
            $table->foreign('ward_id')
                ->references('id')
                ->on('wards')
                ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('nursing_charges');
    }
}
