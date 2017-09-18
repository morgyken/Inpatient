<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateAndTimeOfDeathToDischageNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inpatient_discharge_notes', function (Blueprint $table) {
            $table->date('dateofdeath')->nullable(); 
            $table->string('timeofdeath')->nullable();
            $table->string('type'); // case or discharge
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
