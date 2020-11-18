<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmouringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armourings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);

            // Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('cableSize', 100)->default('');
            $table->string('volt', 100)->default('');
            $table->string('outerDiameter', 100)->default('');
            $table->string('overGapStandard', 100)->default('');
            $table->string('ovalityStandard', 100)->default('');
            $table->string('tapeDimention', 100)->default('');
            $table->string('numberOfWire_wireDim', 100)->default('');
            // Actual
            $table->string('machine', 100)->default('');
            $table->string('inputDrum', 100)->default('');
            $table->string('inputCard', 100)->default('');
            $table->string('inputLength', 100)->default('');
            $table->string('outputDrum', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('outputLength', 100)->default('');
            $table->string('ovalityActual', 100)->default('');
            $table->string('dimAfterStartMin', 100)->default('');
            $table->string('dimAfterStartNom', 100)->default('');
            $table->string('dimAfterStartMax', 100)->default('');
            $table->string('dimAfterEndMin', 100)->default('');
            $table->string('dimAfterEndNom', 100)->default('');
            $table->string('dimAfterEndMax', 100)->default('');
            $table->string('wire_tape', 100)->default('');
            $table->string('overGapActual', 100)->default('');
            $table->string('direction', 100)->default('');
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
        Schema::dropIfExists('armourings');
    }
}
