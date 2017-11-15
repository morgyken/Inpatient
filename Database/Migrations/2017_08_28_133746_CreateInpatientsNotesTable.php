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
            $column->binary('note_pic')->nullable();
            $column->unsignedInteger('user');
            $column->integer('type')->default(0); // 0 - nurse's , 1- doctor's
            $column->timestamps();
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
