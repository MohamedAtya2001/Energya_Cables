<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblystandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblystandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assemblystandards_id');
            $table->foreign('assemblystandards_id')->references('id')->on('assemblystandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('cableSize_time', 100);
            $table->string('cableDescription_time', 100);
            $table->string('outerDimMinStandard_time', 100);
            $table->string('outerDimNomStandard_time', 100);
            $table->string('outerDimMaxStandard_time', 100);
            $table->string('fillerStandard_time', 100);
            $table->string('twistedStandard_time', 100);
            $table->string('overLap_time', 100);
            $table->string('ovalityStandard_time', 100);
            $table->string('layLengthStandard_time', 100);
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
        Schema::dropIfExists('assemblystandardstimes');
    }
}
