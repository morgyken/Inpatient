<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientNotesTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inpatient_notes', function(Blueprint $table) {
            $table->increments('id');
            
            $table->integer('visit_id');

            $table->text('title');

            $table->enum('type', ['nurse', 'doctor']);

            $table->longText('notes');

            $table->timestamps();
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
