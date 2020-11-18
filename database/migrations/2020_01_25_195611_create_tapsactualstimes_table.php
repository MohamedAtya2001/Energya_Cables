<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTapsactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tapsactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tapsactuals_id');
            $table->foreign('tapsactuals_id')->references('id')->on('tapsactuals');
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time', 100)->nullable();
            $table->string('inputDrum_time', 100)->nullable();
            $table->string('inputCard_time', 100)->nullable();
            $table->string('inputLength_time', 100)->nullable();
            $table->string('outputDrum_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('outputLength_time', 100)->nullable();
            $table->string('tapeDimentionActual_time', 100)->nullable();
            $table->string('tapeWeightActual_time', 100)->nullable();
            $table->string('overLapActual_time', 100)->nullable();
            $table->string('dimAfter_time', 100)->nullable();
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
        Schema::dropIfExists('tapsactualstimes');
    }
}
