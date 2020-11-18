<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandingstandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strandingstandards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jopOrderNumber', 100)->unique();
            $table->string('size', 100);
            $table->string('type', 100);
            $table->string('volt', 100);
            $table->string('conductorDimStandard', 100);
            $table->string('preformingLayStandard', 100);
            $table->string('waterBlockingTapStandard', 100);
            $table->string('TDS_number', 100);
            $table->string('conductorWeightStandard', 100);
            $table->string('resistance', 100);
            $table->string('constructionStandard', 100);
            $table->string('layLengthStandard', 100);
            $table->string('powder_grease_weightStandard', 100);
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
        Schema::dropIfExists('strandingstandards');
    }
}
