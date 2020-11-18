<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sheet', 100)->nullable();
            $table->string('issueNumber', 100)->nullable();
            $table->string('issueDate', 100)->nullable();
            $table->string('modifiedDate', 100)->nullable();
            $table->string('durationOfPreservation', 100)->nullable();
            $table->string('material', 100)->nullable();
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
        Schema::dropIfExists('iso');
    }
}
