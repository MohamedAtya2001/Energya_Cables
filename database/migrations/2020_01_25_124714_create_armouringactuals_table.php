<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmouringactualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armouringactuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jopOrderNumber_id');
            $table->foreign('jopOrderNumber_id')->references('id')->on('armouringstandards');
            $table->string('jopOrderNumber', 100);
            $table->string('machine', 100)->nullable();
            $table->string('inputDrum', 100)->nullable();
            $table->string('inputCard', 100)->nullable();
            $table->string('inputLength', 100)->nullable();
            $table->string('outputDrum', 100)->nullable();
            $table->string('outputCard', 100)->nullable();
            $table->string('outputLength', 100)->nullable();
            $table->string('ovalityActual', 100)->nullable();
            $table->string('dimAfterStartMin', 100)->nullable();
            $table->string('dimAfterStartNom', 100)->nullable();
            $table->string('dimAfterStartMax', 100)->nullable();
            $table->string('dimAfterEndMin', 100)->nullable();
            $table->string('dimAfterEndNom', 100)->nullable();
            $table->string('dimAfterEndMax', 100)->nullable();
            $table->string('wire_tape', 100)->nullable();
            $table->string('overGapActual', 100)->nullable();
            $table->string('direction', 100)->nullable();
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
        Schema::dropIfExists('armouringactuals');
    }
}
