<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblyactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assemblyactuals_id');
            $table->foreign('assemblyactuals_id')->references('id')->on('assemblyactuals');
            $table->string('jopOrderNumber_time', 100);
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time', 100)->nullable();
            $table->string('inputDrum1_time', 100)->nullable();
            $table->string('inputDrum2_time', 100)->nullable();
            $table->string('inputDrum3_time', 100)->nullable();
            $table->string('inputDrum4_time', 100)->nullable();
            $table->string('inputDrum5_time', 100)->nullable();
            $table->string('inputCard1_time', 100)->nullable();
            $table->string('inputCard2_time', 100)->nullable();
            $table->string('inputCard3_time', 100)->nullable();
            $table->string('inputCard4_time', 100)->nullable();
            $table->string('inputCard5_time', 100)->nullable();
            $table->string('inputLength1_time', 100)->nullable();
            $table->string('inputLength2_time', 100)->nullable();
            $table->string('inputLength3_time', 100)->nullable();
            $table->string('inputLength4_time', 100)->nullable();
            $table->string('inputLength5_time', 100)->nullable();
            $table->string('color1_time', 100)->nullable();
            $table->string('color2_time', 100)->nullable();
            $table->string('color3_time', 100)->nullable();
            $table->string('color4_time', 100)->nullable();
            $table->string('color5_time', 100)->nullable();
            $table->string('outputDrum_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('outputLength_time', 100)->nullable();
            $table->string('outerDimMinActual_time', 100)->nullable();
            $table->string('outerDimNomActual_time', 100)->nullable();
            $table->string('outerDimMaxActual_time', 100)->nullable();
            $table->string('ovalityActual_time', 100)->nullable();
            $table->string('layLengthActual_time', 100)->nullable();
            $table->string('direction_time', 100)->nullable();
            $table->string('fillerActual_time', 100)->nullable();
            $table->string('twistedActual_time', 100)->nullable();
            $table->string('ppTapeSize_time', 100)->nullable();
            $table->string('ppTapeOverLap_time', 100)->nullable();
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
        Schema::dropIfExists('assemblyactualstimes');
    }
}
