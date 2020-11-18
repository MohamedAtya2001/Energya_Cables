<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcvinsulationstandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccvinsulationstandards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jopOrderNumber', 100)->unique();
            $table->string('size', 100);
            $table->string('description', 100);
            $table->string('thicknessMinISC', 100);
            $table->string('thicknessMinINS', 100);
            $table->string('thicknessMinOSC', 100);
            $table->string('thicknessNomISC', 100);
            $table->string('thicknessNomINS', 100);
            $table->string('thicknessNomOSC', 100);
            $table->string('dimAfter', 100);
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
        Schema::dropIfExists('ccvinsulationstandards');
    }
}
