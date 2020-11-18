<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTapsstandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tapsstandards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jopOrderNumber', 100)->unique();
            $table->string('cableSize', 100);
            $table->string('volt', 100);
            $table->string('overLapStandard', 100);
            $table->string('tapeDimentionStandard', 100);
            $table->string('outerDiameter', 100);
            $table->string('tapeWeightStandard', 100);
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
        Schema::dropIfExists('tapsstandards');
    }
}
