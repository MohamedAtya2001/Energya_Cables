<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmouringstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armouringstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('armouringstandards_id');
            $table->foreign('armouringstandards_id')->references('id')->on('armouringstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('cableSize_time', 100);
            $table->string('volt_time', 100);
            $table->string('outerDiameter_time', 100);
            $table->string('overGapStandard_time', 100);
            $table->string('ovalityStandard_time', 100);
            $table->string('tapeDimention_time', 100);
            $table->string('numberOfWire_wireDim_time', 100);
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
        Schema::dropIfExists('armouringstandardstimes');
    }
}
