<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandingactualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strandingactuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jopOrderNumber_id');
            $table->foreign('jopOrderNumber_id')->references('id')->on('strandingstandards');
            $table->string('jopOrderNumber', 100);
            $table->string('machine', 100)->nullable();
            $table->string('shape', 100)->nullable();
            $table->string('angel', 100)->nullable();
            $table->string('inputCard1', 100)->nullable();
            $table->string('inputCard2', 100)->nullable();
            $table->string('inputCard3', 100)->nullable();
            $table->string('inputCard4', 100)->nullable();
            $table->string('cage1', 100)->nullable();
            $table->string('cage2', 100)->nullable();
            $table->string('cage3', 100)->nullable();
            $table->string('cage4', 100)->nullable();
            $table->string('drumNumber', 100)->nullable();
            $table->string('outputCard', 100)->nullable();
            $table->string('length', 100)->nullable();
            $table->string('constructionActual', 100)->nullable();
            $table->string('conductorDimActual_HS1', 100)->nullable();
            $table->string('conductorDimActual_HS2', 100)->nullable();
            $table->string('conductorDimActual_HS3', 100)->nullable();
            $table->string('conductorDimActual_HS4', 100)->nullable();
            $table->string('conductorDimActual_FI1', 100)->nullable();
            $table->string('conductorDimActual_FI2', 100)->nullable();
            $table->string('conductorDimActual_FI3', 100)->nullable();
            $table->string('conductorDimActual_FI4', 100)->nullable();
            $table->string('ovality', 100)->nullable();
            $table->string('preformingLayActual', 100)->nullable();
            $table->string('waterBlockingTapActual', 100)->nullable();
            $table->string('resistance1', 100)->nullable();
            $table->string('length1', 100)->nullable();
            $table->string('resistance2', 100)->nullable();
            $table->string('length2', 100)->nullable();
            $table->string('resistance3', 100)->nullable();
            $table->string('length3', 100)->nullable();
            $table->string('resistance4', 100)->nullable();
            $table->string('length4', 100)->nullable();
            $table->string('layLengthDirection', 100)->nullable();
            $table->string('conductorWeightActual', 100)->nullable();
            $table->string('layLengthActual', 100)->nullable();
            $table->string('powder_grease_weightActual', 100)->nullable();
            $table->string('visual', 100)->nullable();
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
        Schema::dropIfExists('strandingactuals');
    }
}
