<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewind', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jopOrderNumber', 100);
            $table->string('inputDrum', 100);
            $table->string('inputCard', 100);
            $table->string('inputLength', 100);
            $table->string('outputDrum', 100);
            $table->string('outputCard', 100);
            $table->string('outputLength', 100);
            $table->text('reasonOfRewind');
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
        Schema::dropIfExists('rewind');
    }
}
