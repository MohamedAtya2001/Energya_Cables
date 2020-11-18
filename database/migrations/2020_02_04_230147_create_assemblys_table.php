<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);

            // Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('cableSize', 100)->default('');
            $table->string('cableDescription', 100)->default('');
            $table->string('outerDimMinStandard', 100)->default('');
            $table->string('outerDimNomStandard', 100)->default('');
            $table->string('outerDimMaxStandard', 100)->default('');
            $table->string('fillerStandard', 100)->default('');
            $table->string('twistedStandard', 100)->default('');
            $table->string('overLap', 100)->default('');
            $table->string('ovalityStandard', 100)->default('');
            $table->string('layLengthStandard', 100)->default('');
           
            // Actual
            $table->string('machine', 100)->default('');
            $table->string('inputDrum1', 100)->default('');
            $table->string('inputDrum2', 100)->default('');
            $table->string('inputDrum3', 100)->default('');
            $table->string('inputDrum4', 100)->default('');
            $table->string('inputDrum5', 100)->default('');
            $table->string('inputCard1', 100)->default('');
            $table->string('inputCard2', 100)->default('');
            $table->string('inputCard3', 100)->default('');
            $table->string('inputCard4', 100)->default('');
            $table->string('inputCard5', 100)->default('');
            $table->string('inputLength1', 100)->default('');
            $table->string('inputLength2', 100)->default('');
            $table->string('inputLength3', 100)->default('');
            $table->string('inputLength4', 100)->default('');
            $table->string('inputLength5', 100)->default('');
            $table->string('color1', 100)->default('');
            $table->string('color2', 100)->default('');
            $table->string('color3', 100)->default('');
            $table->string('color4', 100)->default('');
            $table->string('color5', 100)->default('');
            $table->string('outputDrum', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('outputLength', 100)->default('');
            $table->string('outerDimMinActual', 100)->default('');
            $table->string('outerDimNomActual', 100)->default('');
            $table->string('outerDimMaxActual', 100)->default('');
            $table->string('ovalityActual', 100)->default('');
            $table->string('layLengthActual', 100)->default('');
            $table->string('direction', 100)->default('');
            $table->string('fillerActual', 100)->default('');
            $table->string('twistedActual', 100)->default('');
            $table->string('ppTapeSize', 100)->default('');
            $table->string('ppTapeOverLap', 100)->default('');
            $table->string('status', 100)->default('');
            $table->string('productionOperator', 100)->default('');
            $table->string('notes', 100)->default('');

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
        Schema::dropIfExists('assemblys');
    }
}
