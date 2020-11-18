<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leadstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leadstandards_id');
            $table->foreign('leadstandards_id')->references('id')->on('leadstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('size_time', 100);
            $table->string('description_time', 100);
            $table->string('volt_time', 100);
            $table->string('thicknessMinStandard_time', 100);
            $table->string('thicknessNomStandard_time', 100);
            $table->string('thicknessMaxStandard_time', 100);
            $table->string('dimAfter_time', 100);
            $table->string('weightStandard_time', 100);
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
        Schema::dropIfExists('leadstandardstimes');
    }
}
