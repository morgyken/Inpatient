<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientAdministerDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatient_administer_drugs', function (Blueprint $table) {
            
            $table->increments('id');

            $table->integer('dispensing_id');

            $table->boolean('administered')->default(false);

            $table->boolean('administered_at')->default(false);

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
        Schema::dropIfExists('inpatient_administer_drugs');
    }
}
