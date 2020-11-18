<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrowingactualstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drowingactualstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('drowingactuals_id');
            $table->foreign('drowingactuals_id')->references('id')->on('drowingactuals');
            $table->string('jopOrderNumber', 100);
            $table->string('machine_time',  100)->nullable();
            $table->string('coilNumber_time', 100)->nullable();
            $table->string('wireDimMinActual_time', 100)->nullable();
            $table->string('wireDimNomActual_time', 100)->nullable();
            $table->string('wireDimMaxActual_time', 100)->nullable();
            $table->string('elongationActual_time', 100)->nullable();
            $table->string('tensileActual_time', 100)->nullable();
            $table->string('cage_time', 100)->nullable();
            $table->string('outputCard_time', 100)->nullable();
            $table->string('visual_time', 100)->nullable();
            $table->string('status_time', 100)->nullable();
            $table->string('productionOperator_time', 100)->nullable();
            $table->string('notes_time',  100)->nullable();
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
        Schema::dropIfExists('drowingactualstimes');
    }
}
