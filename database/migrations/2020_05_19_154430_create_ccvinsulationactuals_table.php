<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcvinsulationactualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccvinsulationactuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jopOrderNumber_id');
            $table->foreign('jopOrderNumber_id')->references('id')->on('ccvinsulationstandards');
            $table->string('jopOrderNumber', 100);
            $table->string('machine', 100)->nullable();
            $table->string('inputDrum', 100)->nullable();
            $table->string('inputCard', 100)->nullable();
            $table->string('inputLength', 100)->nullable();
            $table->string('outputDrum', 100)->nullable();
            $table->string('outputCard', 100)->nullable();
            $table->string('outputLength', 100)->nullable();
            $table->string('thicknessISCStartMin', 100)->nullable();
            $table->string('thicknessISCStartNom', 100)->nullable();
            $table->string('thicknessISCStartMax', 100)->nullable();
            $table->string('thicknessINSStartMin', 100)->nullable();
            $table->string('thicknessINSStartNom', 100)->nullable();
            $table->string('thicknessINSStartMax', 100)->nullable();
            $table->string('thicknessOSCStartMin', 100)->nullable();
            $table->string('thicknessOSCStartNom', 100)->nullable();
            $table->string('thicknessOSCStartMax', 100)->nullable();
            $table->string('thicknessISCEndMin', 100)->nullable();
            $table->string('thicknessISCEndNom', 100)->nullable();
            $table->string('thicknessISCEndMax', 100)->nullable();
            $table->string('thicknessINSEndMin', 100)->nullable();
            $table->string('thicknessINSEndNom', 100)->nullable();
            $table->string('thicknessINSEndMax', 100)->nullable();
            $table->string('thicknessOSCEndMin', 100)->nullable();
            $table->string('thicknessOSCEndNom', 100)->nullable();
            $table->string('thicknessOSCEndMax', 100)->nullable();
            $table->string('dimBefore1', 100)->nullable();
            $table->string('dimBefore2', 100)->nullable();
            $table->string('dimAfterStartMin', 100)->nullable();
            $table->string('dimAfterStartNom', 100)->nullable();
            $table->string('dimAfterStartMax', 100)->nullable();
            $table->string('dimAfterEndMin', 100)->nullable();
            $table->string('dimAfterEndNom', 100)->nullable();
            $table->string('dimAfterEndMax', 100)->nullable();
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
        Schema::dropIfExists('ccvinsulationactuals');
    }
}
