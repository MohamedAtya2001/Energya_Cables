<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatScreenactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screenactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('screenactuals_id');
            $table->foreign('screenactuals_id')->references('id')->on('screenactuals');
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time', 100)->nullable();
            $table->string('inputDrum_time', 100)->nullable();
            $table->string('inputCard_time', 100)->nullable();
            $table->string('inputLength_time', 100)->nullable();
            $table->string('outputDrum_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('outputLength_time', 100)->nullable();
            $table->string('color_time', 100)->nullable();
            $table->string('tapeWeight_time', 100)->nullable();
            $table->string('wireWeight_time', 100)->nullable();
            $table->string('overLapActual1_time', 100)->nullable();
            $table->string('overLapActual2_time', 100)->nullable();
            $table->string('overLapActual3_time', 100)->nullable();
            $table->string('overLapActual4_time', 100)->nullable();
            $table->string('dimAfter1_time', 100)->nullable();
            $table->string('dimAfter2_time', 100)->nullable();
            $table->string('dimAfter3_time', 100)->nullable();
            $table->string('dimAfter4_time', 100)->nullable();
            $table->string('tapeDimention_time', 100)->nullable();
            $table->string('status_time', 100)->nullable();
            $table->string('productionOperator_time', 100)->nullable();
            $table->string('notes_time',  100)->nullable();
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
        Schema::dropIfExists('screenactualstimes');
    }
}
