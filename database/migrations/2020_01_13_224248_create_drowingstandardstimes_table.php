<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrowingstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drowingstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('drowingstandards_id');
            $table->foreign('drowingstandards_id')->references('id')->on('drowingstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('wireDimMinStandard_time', 100);
            $table->string('wireDimNomStandard_time', 100);
            $table->string('wireDimMaxStandard_time', 100);
            $table->string('size_time', 100);
            $table->string('volt_time', 100);
            $table->string('elongationStandard_time', 100);
            $table->string('tensileStandard_time', 100)->nullable();
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
        Schema::dropIfExists('drowingstandardstimes');
    }
}
