<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrowingstandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drowingstandards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jopOrderNumber', 100)->unique();
            $table->string('wireDimMinStandard', 100);
            $table->string('wireDimNomStandard', 100);
            $table->string('wireDimMaxStandard', 100);
            $table->string('size', 100);
            $table->string('volt', 100);
            $table->string('elongationStandard', 100);
            $table->string('tensileStandard', 100);
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
        Schema::dropIfExists('drowingstandards');
    }
}
