<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientFluidBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_fluidbalance', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('admission_id');
            $column->unsignedInteger('user_id');
            $column->string('bp_systolic')->nullable();
            $column->longText('intravenous_infusion')->nullable();
            $column->longText('other_instructions')->nullable();
            $column->text('intake_intraveneous');
            $column->text('intake_alimentary');
            $column->text('output');
            $column->timestamps();
           
            $column->foreign('admission_id')->references('id')->on('admissions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('inpatient_fluidbalance');
    }
}
