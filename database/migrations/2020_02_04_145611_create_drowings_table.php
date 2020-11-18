<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drowings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_item');
            $table->string('employee_name', 100);
            // Standard
            $table->string('jopOrderNumber', 100)->default('');
            $table->string('wireDimMinStandard', 100)->default('');
            $table->string('wireDimNomStandard', 100)->default('');
            $table->string('wireDimMaxStandard', 100)->default('');
            $table->string('size', 100)->default('');
            $table->string('volt', 100)->default('');
            $table->string('elongationStandard', 100)->default('');
            $table->string('tensileStandard', 100)->default('');
            // Actual
            $table->string('machine',  100)->default('');
            $table->string('coilNumber', 100)->default('');
            $table->string('wireDimMinActual', 100)->default('');
            $table->string('wireDimNomActual', 100)->default('');
            $table->string('wireDimMaxActual', 100)->default('');
            $table->string('elongationActual', 100)->default('');
            $table->string('tensileActual', 100)->default('');
            $table->string('cage', 100)->default('');
            $table->string('outputCard', 100)->default('');
            $table->string('visual', 100)->default('');
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
        Schema::dropIfExists('drowings');
    }
}
