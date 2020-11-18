<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblystandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblystandards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jopOrderNumber', 100)->unique();
            $table->string('cableSize', 100);
            $table->string('cableDescription', 100);
            $table->string('outerDimMinStandard', 100);
            $table->string('outerDimNomStandard', 100);
            $table->string('outerDimMaxStandard', 100);
            $table->string('fillerStandard', 100);
            $table->string('twistedStandard', 100);
            $table->string('overLap', 100);
            $table->string('ovalityStandard', 100);
            $table->string('layLengthStandard', 100);
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
        Schema::dropIfExists('assemblystandards');
    }
}
