<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrowingactualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drowingactuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jopOrderNumber_id');
            $table->foreign('jopOrderNumber_id')->references('id')->on('drowingstandards');
            $table->string('jopOrderNumber', 100);
            $table->string('machine',  100)->nullable();
            $table->string('coilNumber', 100)->nullable();
            $table->string('wireDimMinActual', 100)->nullable();
            $table->string('wireDimNomActual', 100)->nullable();
            $table->string('wireDimMaxActual', 100)->nullable();
            $table->string('elongationActual', 100)->nullable();
            $table->string('tensileActual', 100)->nullable();
            $table->string('cage', 100)->nullable();
            $table->string('outputCard', 100)->nullable();
            $table->string('visual', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('productionOperator', 100)->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('drowingactuals');
    }
}
