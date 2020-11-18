<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strandings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);
            // Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('size', 100)->default('');
            $table->string('type', 100)->default('');
            $table->string('volt', 100)->default('');
            $table->string('conductorDimStandard', 100)->default('');
            $table->string('preformingLayStandard', 100)->default('');
            $table->string('waterBlockingTapStandard', 100)->default('');
            $table->string('TDS_number', 100)->default('');
            $table->string('conductorWeightStandard', 100)->default('');
            $table->string('resistance', 100)->default('');
            $table->string('constructionStandard', 100)->default('');
            $table->string('layLengthStandard', 100)->default('');
            $table->string('powder_grease_weightStandard', 100)->default('');
            //Actual
            $table->string('machine', 100)->default('');
            $table->string('shape', 100)->default('');
            $table->string('angel', 100)->default('');
            $table->string('inputCard1', 100)->default('');
            $table->string('inputCard2', 100)->default('');
            $table->string('inputCard3', 100)->default('');
            $table->string('inputCard4', 100)->default('');
            $table->string('cage1', 100)->default('');
            $table->string('cage2', 100)->default('');
            $table->string('cage3', 100)->default('');
            $table->string('cage4', 100)->default('');
            $table->string('drumNumber', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('length', 100)->default('');
            $table->string('constructionActual', 100)->default('');
            $table->string('conductorDimActual_HS1', 100)->default('');
            $table->string('conductorDimActual_HS2', 100)->default('');
            $table->string('conductorDimActual_HS3', 100)->default('');
            $table->string('conductorDimActual_HS4', 100)->default('');
            $table->string('conductorDimActual_FI1', 100)->default('');
            $table->string('conductorDimActual_FI2', 100)->default('');
            $table->string('conductorDimActual_FI3', 100)->default('');
            $table->string('conductorDimActual_FI4', 100)->default('');
            $table->string('ovality', 100)->default('');
            $table->string('preformingLayActual', 100)->default('');
            $table->string('waterBlockingTapActual', 100)->default('');
            $table->string('resistance1', 100)->default('');
            $table->string('length1', 100)->default('');
            $table->string('resistance2', 100)->default('');
            $table->string('length2', 100)->default('');
            $table->string('resistance3', 100)->default('');
            $table->string('length3', 100)->default('');
            $table->string('resistance4', 100)->default('');
            $table->string('length4', 100)->default('');
            $table->string('layLengthDirection', 100)->default('');
            $table->string('conductorWeightActual', 100)->default('');
            $table->string('layLengthActual', 100)->default('');
            $table->string('powder_grease_weightActual', 100)->default('');
            $table->string('visual', 100)->default('');
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
        Schema::dropIfExists('strandings');
    }
}
