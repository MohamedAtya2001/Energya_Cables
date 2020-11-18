<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandingactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strandingactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('strandingactuals_id');
            $table->foreign('strandingactuals_id')->references('id')->on('strandingactuals');
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time', 100)->nullable();
            $table->string('shape_time', 100)->nullable();
            $table->string('angel_time', 100)->nullable();
            $table->string('inputCard1_time', 100)->nullable();
            $table->string('inputCard2_time', 100)->nullable();
            $table->string('inputCard3_time', 100)->nullable();
            $table->string('inputCard4_time', 100)->nullable();
            $table->string('cage1_time', 100)->nullable();
            $table->string('cage2_time', 100)->nullable();
            $table->string('cage3_time', 100)->nullable();
            $table->string('cage4_time', 100)->nullable();
            $table->string('drumNumber_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('length_time', 100)->nullable();
            $table->string('constructionActual_time', 100)->nullable();
            $table->string('conductorDimActual_HS1_time', 100)->nullable();
            $table->string('conductorDimActual_HS2_time', 100)->nullable();
            $table->string('conductorDimActual_HS3_time', 100)->nullable();
            $table->string('conductorDimActual_HS4_time', 100)->nullable();
            $table->string('conductorDimActual_FI1_time', 100)->nullable();
            $table->string('conductorDimActual_FI2_time', 100)->nullable();
            $table->string('conductorDimActual_FI3_time', 100)->nullable();
            $table->string('conductorDimActual_FI4_time', 100)->nullable();
            $table->string('ovality_time', 100)->nullable();
            $table->string('preformingLayActual_time', 100)->nullable();
            $table->string('waterBlockingTapActual_time', 100)->nullable();
            $table->string('resistance1_time', 100)->nullable();
            $table->string('length1_time', 100)->nullable();
            $table->string('resistance2_time', 100)->nullable();
            $table->string('length2_time', 100)->nullable();
            $table->string('resistance3_time', 100)->nullable();
            $table->string('length3_time', 100)->nullable();
            $table->string('resistance4_time', 100)->nullable();
            $table->string('length4_time', 100)->nullable();
            $table->string('layLengthDirection_time', 100)->nullable();
            $table->string('conductorWeightActual_time', 100)->nullable();
            $table->string('layLengthActual_time', 100)->nullable();
            $table->string('powder_grease_weightActual_time', 100)->nullable();
            $table->string('visual_time', 100)->nullable();
            $table->string('status_time', 100)->nullable();
            $table->string('productionOperator_time', 100)->nullable();
            $table->string('notes_time',  100)->nullable();
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
        Schema::dropIfExists('strandingactualstimes');
    }
}
