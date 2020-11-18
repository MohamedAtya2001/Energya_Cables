<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcvinsulationstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccvinsulationstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ccvinsulationstandards_id');
            $table->foreign('ccvinsulationstandards_id')->references('id')->on('ccvinsulationstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('size_time', 100);
            $table->string('description_time', 100);
            $table->string('thicknessMinISC_time', 100);
            $table->string('thicknessMinINS_time', 100);
            $table->string('thicknessMinOSC_time', 100);
            $table->string('thicknessNomISC_time', 100);
            $table->string('thicknessNomINS_time', 100);
            $table->string('thicknessNomOSC_time', 100);
            $table->string('dimAfter_time', 100);
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
        Schema::dropIfExists('ccvinsulationstandardstimes');
    }
}
