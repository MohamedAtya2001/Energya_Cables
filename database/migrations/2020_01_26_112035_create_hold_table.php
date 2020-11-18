<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hold', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sheet_id')->nullable();
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('drumNumber', 100)->default('');
            $table->string('cableSize', 100)->default('');
            $table->string('length', 100)->default('');
            $table->string('description', 100)->default('');
            $table->string('machine', 100)->default('');
            $table->text('reasonOfHold')->default('');
            $table->string('fromSheet', 100)->default('');
            $table->string('added_by', 100);
            $table->string('shift', 100);
            $table->boolean('released')->default(false);
            $table->string('released_by', 100)->default('');
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
        Schema::dropIfExists('hold');
    }
}
