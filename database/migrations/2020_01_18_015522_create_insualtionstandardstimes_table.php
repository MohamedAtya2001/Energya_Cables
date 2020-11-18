<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsualtionstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insulationstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('insulationstandards_id');
            $table->foreign('insulationstandards_id')->references('id')->on('insulationstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('cableSize_time', 100);
            $table->string('cableDescription_time', 100);
            $table->string('volt_time', 100);
            $table->string('thicknessMinStandard_time', 100);
            $table->string('thicknessNomStandard_time', 100);
            $table->string('thicknessMaxStandard_time', 100);
            $table->string('eccentricityStandard_time', 100);
            $table->string('outerDim_time', 100);
            $table->string('ovalityStandard_time', 100);
            $table->string('materialStandard_time', 100);
            $table->string('colorStandard_time', 100);
            $table->string('sparkStandard_time', 100);
            $table->string('weightStandard_time', 100);
            $table->string('masterPatch_time', 100);
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
        Schema::dropIfExists('insulationstandardstimes');
    }
}
