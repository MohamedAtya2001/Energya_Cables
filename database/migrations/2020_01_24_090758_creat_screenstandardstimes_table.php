<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatScreenstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screenstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('screenstandards_id');
            $table->foreign('screenstandards_id')->references('id')->on('screenstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('size_type_time', 100);
            $table->string('volt_time', 100);
            $table->string('overLapStandard_time', 100);
            $table->string('outerDiameter_time', 100);
            $table->string('numberOfWire_wireDim_time', 100);
            $table->string('tape_wire_weight_time', 100);
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
        Schema::dropIfExists('screenstandardstimes');
    }
}
