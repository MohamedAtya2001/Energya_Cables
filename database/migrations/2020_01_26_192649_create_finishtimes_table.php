<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finishtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('finish_id');
            $table->foreign('finish_id')->references('id')->on('finish');
            $table->string('jopOrderNumber_time', 100);
            $table->string('drumNumber_time', 100);
            $table->string('length_time', 100);
            $table->string('notes_time', 100)->nullable();
            $table->string('added_by', 100);
            $table->string('shift', 100);
            $table->string('updated_by', 100)->nullable();
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
        Schema::dropIfExists('finishtimes');
    }
}
