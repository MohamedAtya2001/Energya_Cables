<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadactualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leadactuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jopOrderNumber_id');
            $table->foreign('jopOrderNumber_id')->references('id')->on('leadstandards');
            $table->string('jopOrderNumber', 100);
            $table->string('machine', 100)->nullable();
            $table->string('inputDrum', 100)->nullable();
            $table->string('inputCard', 100)->nullable();
            $table->string('inputLength', 100)->nullable();
            $table->string('outputDrum', 100)->nullable();
            $table->string('outputCard', 100)->nullable();
            $table->string('outputLength', 100)->nullable();
            $table->string('thicknessStartMinActual', 100)->nullable();
            $table->string('thicknessStartNomActual', 100)->nullable();
            $table->string('thicknessStartMaxActual', 100)->nullable();
            $table->string('thicknessEndMinActual', 100)->nullable();
            $table->string('thicknessEndNomActual', 100)->nullable();
            $table->string('thicknessEndMaxActual', 100)->nullable();
            $table->string('dimBefore1', 100)->nullable();
            $table->string('dimBefore2', 100)->nullable();
            $table->string('dimAfterStart', 100)->nullable();
            $table->string('dimAfterEnd', 100)->nullable();
            $table->string('weightActual', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('productionOperator', 100)->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('leadactuals');
    }
}
