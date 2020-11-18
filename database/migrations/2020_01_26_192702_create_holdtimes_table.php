<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoldtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holdtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hold_id');
            $table->foreign('hold_id')->references('id')->on('hold');
            $table->string('jopOrderNumber_time', 100)->default('');
            $table->string('drumNumber_time', 100)->default('');
            $table->string('cableSize_time', 100)->default('');
            $table->string('length_time', 100)->default('');
            $table->string('description_time', 100)->default('');
            $table->string('machine_time', 100)->default('');
            $table->string('reasonOfHold_time', 100)->default('');
            $table->string('added_by', 100);
            $table->string('shift', 100);
            $table->string('released_time', 100)->default('');
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
        Schema::dropIfExists('holdtimes');
    }
}
