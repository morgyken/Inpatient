<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward_assigned', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_id');
            $table->unsignedInteger('visit_id')->nullable();
            $table->unsignedInteger('ward_id');
            $table->timestamp('admitted_at')->nullable();
            $table->timestamp('discharged_at')->nullable();
            $table->double('price',2)->default(0);
            $table->string('status')->default('unpaid');
            $table->timestamps();

            $table->foreign('admission_id')->references('id')
            ->on('admissions')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('visit_id')
            ->references('id')
            ->on('evaluation_visits')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('ward_id')
            ->references('id')
            ->on('wards')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ward_assigned');
    }
}
