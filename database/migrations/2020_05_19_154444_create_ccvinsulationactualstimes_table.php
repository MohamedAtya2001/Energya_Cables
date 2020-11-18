<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcvinsulationactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccvinsulationactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ccvinsulationactuals_id');
            $table->foreign('ccvinsulationactuals_id')->references('id')->on('ccvinsulationactuals');
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time', 100)->nullable();
            $table->string('inputDrum_time', 100)->nullable();
            $table->string('inputCard_time', 100)->nullable();
            $table->string('inputLength_time', 100)->nullable();
            $table->string('outputDrum_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('outputLength_time', 100)->nullable();
            $table->string('thicknessISCStartMin_time', 100)->nullable();
            $table->string('thicknessISCStartNom_time', 100)->nullable();
            $table->string('thicknessISCStartMax_time', 100)->nullable();
            $table->string('thicknessINSStartMin_time', 100)->nullable();
            $table->string('thicknessINSStartNom_time', 100)->nullable();
            $table->string('thicknessINSStartMax_time', 100)->nullable();
            $table->string('thicknessOSCStartMin_time', 100)->nullable();
            $table->string('thicknessOSCStartNom_time', 100)->nullable();
            $table->string('thicknessOSCStartMax_time', 100)->nullable();
            $table->string('thicknessISCEndMin_time', 100)->nullable();
            $table->string('thicknessISCEndNom_time', 100)->nullable();
            $table->string('thicknessISCEndMax_time', 100)->nullable();
            $table->string('thicknessINSEndMin_time', 100)->nullable();
            $table->string('thicknessINSEndNom_time', 100)->nullable();
            $table->string('thicknessINSEndMax_time', 100)->nullable();
            $table->string('thicknessOSCEndMin_time', 100)->nullable();
            $table->string('thicknessOSCEndNom_time', 100)->nullable();
            $table->string('thicknessOSCEndMax_time', 100)->nullable();
            $table->string('dimBefore1_time', 100)->nullable();
            $table->string('dimBefore2_time', 100)->nullable();
            $table->string('dimAfterStartMin_time', 100)->nullable();
            $table->string('dimAfterStartNom_time', 100)->nullable();
            $table->string('dimAfterStartMax_time', 100)->nullable();
            $table->string('dimAfterEndMin_time', 100)->nullable();
            $table->string('dimAfterEndNom_time', 100)->nullable();
            $table->string('dimAfterEndMax_time', 100)->nullable();
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
        Schema::dropIfExists('ccvinsulationactualstimes');
    }
}
