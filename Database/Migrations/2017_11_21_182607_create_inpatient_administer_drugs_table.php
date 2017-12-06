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

            $table->integer('prescription_id');

            $table->integer('administered');

            $table->timestamp('user_id');

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
