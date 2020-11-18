<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leadactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leadactuals_id');
            $table->foreign('leadactuals_id')->references('id')->on('leadactuals');
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time', 100)->nullable();
            $table->string('inputDrum_time', 100)->nullable();
            $table->string('inputCard_time', 100)->nullable();
            $table->string('inputLength_time', 100)->nullable();
            $table->string('outputDrum_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('outputLength_time', 100)->nullable();
            $table->string('thicknessStartMinActual_time', 100)->nullable();
            $table->string('thicknessStartNomActual_time', 100)->nullable();
            $table->string('thicknessStartMaxActual_time', 100)->nullable();
            $table->string('thicknessEndMinActual_time', 100)->nullable();
            $table->string('thicknessEndNomActual_time', 100)->nullable();
            $table->string('thicknessEndMaxActual_time', 100)->nullable();
            $table->string('dimBefore1_time', 100)->nullable();
            $table->string('dimBefore2_time', 100)->nullable();
            $table->string('dimAfterStart_time', 100)->nullable();
            $table->string('dimAfterEnd_time', 100)->nullable();
            $table->string('weightActual_time', 100)->nullable();
            $table->string('status_time', 100)->nullable();
            $table->string('productionOperator_time', 100)->nullable();
            $table->text('notes_time')->nullable();
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
        Schema::dropIfExists('leadactualstimes');
    }
}
