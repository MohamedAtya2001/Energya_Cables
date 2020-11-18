<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadstandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leadstandards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jopOrderNumber', 100)->unique();
            $table->string('size', 100);
            $table->string('description', 100);
            $table->string('volt', 100);
            $table->string('thicknessMinStandard', 100);
            $table->string('thicknessNomStandard', 100);
            $table->string('thicknessMaxStandard', 100);
            $table->string('dimAfter', 100);
            $table->string('weightStandard', 100);
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
        Schema::dropIfExists('leadstandards');
    }
}
