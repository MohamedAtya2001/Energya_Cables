<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);

            //Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('size', 100)->default('');
            $table->string('description', 100)->default('');
            $table->string('volt', 100)->default('');
            $table->string('thicknessMinStandard', 100)->default('');
            $table->string('thicknessNomStandard', 100)->default('');
            $table->string('thicknessMaxStandard', 100)->default('');
            $table->string('dimAfter', 100)->default('');
            $table->string('weightStandard', 100)->default('');

            //Actual
            $table->string('machine', 100)->default('');
            $table->string('inputDrum', 100)->default('');
            $table->string('inputCard', 100)->default('');
            $table->string('inputLength', 100)->default('');
            $table->string('outputDrum', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('outputLength', 100)->default('');
            $table->string('thicknessStartMinActual', 100)->default('');
            $table->string('thicknessStartNomActual', 100)->default('');
            $table->string('thicknessStartMaxActual', 100)->default('');
            $table->string('thicknessEndMinActual', 100)->default('');
            $table->string('thicknessEndNomActual', 100)->default('');
            $table->string('thicknessEndMaxActual', 100)->default('');
            $table->string('dimBefore1', 100)->default('');
            $table->string('dimBefore2', 100)->default('');
            $table->string('dimAfterStart', 100)->default('');
            $table->string('dimAfterEnd', 100)->default('');
            $table->string('weightActual', 100)->default('');
            $table->string('status', 100)->default('');
            $table->string('productionOperator', 100)->default('');
            $table->text('notes')->default('');

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
        Schema::dropIfExists('leads');
    }
}
