<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyactualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblyactuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jopOrderNumber_id');
            $table->foreign('jopOrderNumber_id')->references('id')->on('assemblystandards');
            $table->string('jopOrderNumber', 100);
            $table->string('machine', 100)->nullable();
            $table->string('inputDrum1', 100)->nullable();
            $table->string('inputDrum2', 100)->nullable();
            $table->string('inputDrum3', 100)->nullable();
            $table->string('inputDrum4', 100)->nullable();
            $table->string('inputDrum5', 100)->nullable();
            $table->string('inputCard1', 100)->nullable();
            $table->string('inputCard2', 100)->nullable();
            $table->string('inputCard3', 100)->nullable();
            $table->string('inputCard4', 100)->nullable();
            $table->string('inputCard5', 100)->nullable();
            $table->string('inputLength1', 100)->nullable();
            $table->string('inputLength2', 100)->nullable();
            $table->string('inputLength3', 100)->nullable();
            $table->string('inputLength4', 100)->nullable();
            $table->string('inputLength5', 100)->nullable();
            $table->string('color1', 100)->nullable();
            $table->string('color2', 100)->nullable();
            $table->string('color3', 100)->nullable();
            $table->string('color4', 100)->nullable();
            $table->string('color5', 100)->nullable();
            $table->string('outputDrum', 100)->nullable();
            $table->string('outputCard', 100)->nullable();
            $table->string('outputLength', 100)->nullable();
            $table->string('outerDimMinActual', 100)->nullable();
            $table->string('outerDimNomActual', 100)->nullable();
            $table->string('outerDimMaxActual', 100)->nullable();
            $table->string('ovalityActual', 100)->nullable();
            $table->string('layLengthActual', 100)->nullable();
            $table->string('direction', 100)->nullable();
            $table->string('fillerActual', 100)->nullable();
            $table->string('twistedActual', 100)->nullable();
            $table->string('ppTapeSize', 100)->nullable();
            $table->string('ppTapeOverLap', 100)->nullable();
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
        Schema::dropIfExists('assemblyactuals');
    }
}
