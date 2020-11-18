<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);

            // Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('cableSize', 100)->default('');
            $table->string('volt', 100)->default('');
            $table->string('overLapStandard', 100)->default('');
            $table->string('tapeDimentionStandard', 100)->default('');
            $table->string('outerDiameter', 100)->default('');
            $table->string('tapeWeightStandard', 100)->default('');
            // Actual
            $table->string('machine', 100)->default('');
            $table->string('inputDrum', 100)->default('');
            $table->string('inputCard', 100)->default('');
            $table->string('inputLength', 100)->default('');
            $table->string('outputDrum', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('outputLength', 100)->default('');
            $table->string('tapeDimentionActual', 100)->default('');
            $table->string('tapeWeightActual', 100)->default('');
            $table->string('overLapActual', 100)->default('');
            $table->string('dimAfter', 100)->default('');
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
        Schema::dropIfExists('taps');
    }
}
