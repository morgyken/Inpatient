<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientsNotesTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_notes', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('admission_id');
            $column->unsignedInteger('visit_id');
            $column->longText('notes');
            $column->unsignedInteger('user');
            $column->integer('type')->default(0); // 0 - nurse's , 1- doctor's
            $column->timestamps();

            $column->foreign('admission_id')
                    ->references('id')
                    ->on('admissions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('visit_id')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('inpatient_notes');
    }
}
