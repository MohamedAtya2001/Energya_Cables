<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTapsstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tapsstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tapsstandards_id');
            $table->foreign('tapsstandards_id')->references('id')->on('tapsstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('cableSize_time', 100);
            $table->string('volt_time', 100);
            $table->string('overLapStandard_time', 100);
            $table->string('tapeDimentionStandard_time', 100);
            $table->string('outerDiameter_time', 100);
            $table->string('tapeWeightStandard_time', 100);
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
        Schema::dropIfExists('tapsstandardstimes');
    }
}
