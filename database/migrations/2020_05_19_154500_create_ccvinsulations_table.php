<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcvinsulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccvinsulations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);

            //Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('size', 100)->default('');
            $table->string('description', 100)->default('');
            $table->string('thicknessMinISC', 100)->default('');
            $table->string('thicknessMinINS', 100)->default('');
            $table->string('thicknessMinOSC', 100)->default('');
            $table->string('thicknessNomISC', 100)->default('');
            $table->string('thicknessNomINS', 100)->default('');
            $table->string('thicknessNomOSC', 100)->default('');
            $table->string('dimAfter', 100)->default('');

            //Actual
            $table->string('machine', 100)->default('');
            $table->string('inputDrum', 100)->default('');
            $table->string('inputCard', 100)->default('');
            $table->string('inputLength', 100)->default('');
            $table->string('outputDrum', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('outputLength', 100)->default('');
            $table->string('thicknessISCStartMin', 100)->default('');
            $table->string('thicknessISCStartNom', 100)->default('');
            $table->string('thicknessISCStartMax', 100)->default('');
            $table->string('thicknessINSStartMin', 100)->default('');
            $table->string('thicknessINSStartNom', 100)->default('');
            $table->string('thicknessINSStartMax', 100)->default('');
            $table->string('thicknessOSCStartMin', 100)->default('');
            $table->string('thicknessOSCStartNom', 100)->default('');
            $table->string('thicknessOSCStartMax', 100)->default('');
            $table->string('thicknessISCEndMin', 100)->default('');
            $table->string('thicknessISCEndNom', 100)->default('');
            $table->string('thicknessISCEndMax', 100)->default('');
            $table->string('thicknessINSEndMin', 100)->default('');
            $table->string('thicknessINSEndNom', 100)->default('');
            $table->string('thicknessINSEndMax', 100)->default('');
            $table->string('thicknessOSCEndMin', 100)->default('');
            $table->string('thicknessOSCEndNom', 100)->default('');
            $table->string('thicknessOSCEndMax', 100)->default('');
            $table->string('dimBefore1', 100)->default('');
            $table->string('dimBefore2', 100)->default('');
            $table->string('dimAfterStartMin', 100)->default('');
            $table->string('dimAfterStartNom', 100)->default('');
            $table->string('dimAfterStartMax', 100)->default('');
            $table->string('dimAfterEndMin', 100)->default('');
            $table->string('dimAfterEndNom', 100)->default('');
            $table->string('dimAfterEndMax', 100)->default('');
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
        Schema::dropIfExists('ccvinsulations');
    }
}
