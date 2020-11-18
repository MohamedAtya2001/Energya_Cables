<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatScreenactualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screenactuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jopOrderNumber_id');
            $table->foreign('jopOrderNumber_id')->references('id')->on('screenstandards');
            $table->string('jopOrderNumber', 100);
            $table->string('machine', 100)->nullable();
            $table->string('inputDrum', 100)->nullable();
            $table->string('inputCard', 100)->nullable();
            $table->string('inputLength', 100)->nullable();
            $table->string('outputDrum', 100)->nullable();
            $table->string('outputCard', 100)->nullable();
            $table->string('outputLength', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->string('tapeWeight', 100)->nullable();
            $table->string('wireWeight', 100)->nullable();
            $table->string('overLapActual1', 100)->nullable();
            $table->string('overLapActual2', 100)->nullable();
            $table->string('overLapActual3', 100)->nullable();
            $table->string('overLapActual4', 100)->nullable();
            $table->string('dimAfter1', 100)->nullable();
            $table->string('dimAfter2', 100)->nullable();
            $table->string('dimAfter3', 100)->nullable();
            $table->string('dimAfter4', 100)->nullable();
            $table->string('tapeDimention', 100)->nullable();
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
        Schema::dropIfExists('screenactuals');
    }
}
