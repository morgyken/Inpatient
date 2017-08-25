<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InpatientNotesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_notes', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit_id')->unsigned();
            $column->longText('notes')->nullable();
            $column->integer('user')->unsigned()->nullable();
            $column->integer('type')->default(0); // 0 - nurse's , 1- doctor's
            $column->timestamps();

            $column->foreign('visit_id')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')->references('id')->on('users')
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
        Schema::drop('inpatient_notes');
    }

}
