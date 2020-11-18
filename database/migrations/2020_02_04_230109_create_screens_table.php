<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);

            //Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('size_type', 100)->default('');
            $table->string('volt', 100)->default('');
            $table->string('overLapStandard', 100)->default('');
            $table->string('outerDiameter', 100)->default('');
            $table->string('numberOfWire_wireDim', 100)->default('');
            $table->string('tape_wire_weight', 100)->default('');
            //Actual
            $table->string('machine', 100)->default('');
            $table->string('inputDrum', 100)->default('');
            $table->string('inputCard', 100)->default('');
            $table->string('inputLength', 100)->default('');
            $table->string('outputDrum', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('outputLength', 100)->default('');
            $table->string('color', 100)->default('');
            $table->string('tapeWeight', 100)->default('');
            $table->string('wireWeight', 100)->default('');
            $table->string('overLapActual1', 100)->default('');
            $table->string('overLapActual2', 100)->default('');
            $table->string('overLapActual3', 100)->default('');
            $table->string('overLapActual4', 100)->default('');
            $table->string('dimAfter1', 100)->default('');
            $table->string('dimAfter2', 100)->default('');
            $table->string('dimAfter3', 100)->default('');
            $table->string('dimAfter4', 100)->default('');
            $table->string('tapeDimention', 100)->default('');
            $table->string('status', 100)->default('');
            $table->string('productionOperator', 100)->default('');
            $table->text('notes')->default('');

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
        Schema::dropIfExists('screens');
    }
}
