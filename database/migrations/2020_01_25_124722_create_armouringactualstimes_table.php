<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmouringactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armouringactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('armouringactuals_id');
            $table->foreign('armouringactuals_id')->references('id')->on('armouringactuals');
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time', 100)->nullable();
            $table->string('inputDrum_time', 100)->nullable();
            $table->string('inputCard_time', 100)->nullable();
            $table->string('inputLength_time', 100)->nullable();
            $table->string('outputDrum_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('outputLength_time', 100)->nullable();
            $table->string('ovalityActual_time', 100)->nullable();
            $table->string('dimAfterStartMin_time', 100)->nullable();
            $table->string('dimAfterStartNom_time', 100)->nullable();
            $table->string('dimAfterStartMax_time', 100)->nullable();
            $table->string('dimAfterEndMin_time', 100)->nullable();
            $table->string('dimAfterEndNom_time', 100)->nullable();
            $table->string('dimAfterEndMax_time', 100)->nullable();
            $table->string('wire_tape_time', 100)->nullable();
            $table->string('overGapActual_time', 100)->nullable();
            $table->string('direction_time', 100)->nullable();
            $table->string('status_time', 100)->nullable();
            $table->string('productionOperator_time', 100)->nullable();
            $table->string('notes_time', 100)->nullable();
            $table->string('added_by', 100);
            $table->string('shift', 100);
            $table->string('updated_by', 100)->default('');
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
        Schema::dropIfExists('armouringactualstimes');
    }
}
