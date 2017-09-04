<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed_position', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('ward_id')->unsigned();
            $table->enum('status',['available','occupied'])->default('available');
            $table->timestamps();

            $table->foreign('ward_id')
                ->references('id')
                ->on('wards')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bed_position');
    }
}
