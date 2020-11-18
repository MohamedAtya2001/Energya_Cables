<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewindtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewindtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rewind_id');
            $table->foreign('rewind_id')->references('id')->on('rewind');
            $table->string('jopOrderNumber_time', 100);
            $table->string('inputDrum_time', 100);
            $table->string('inputCard_time', 100);
            $table->string('inputLength_time', 100);
            $table->string('outputDrum_time', 100);
            $table->string('outputCard_time', 100);
            $table->string('outputLength_time', 100);
            $table->string('reasonOfRewind_time', 100);
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
        Schema::dropIfExists('rewindtimes');
    }
}
