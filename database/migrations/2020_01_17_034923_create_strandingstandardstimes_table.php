<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandingstandardstimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strandingstandardstimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('strandingstandards_id');
            $table->foreign('strandingstandards_id')->references('id')->on('strandingstandards');
            $table->string('jopOrderNumber_time', 100);
            $table->string('size_time', 100);
            $table->string('type_time', 100);
            $table->string('volt_time', 100);
            $table->string('conductorDimStandard_time', 100);
            $table->string('preformingLayStandard_time', 100);
            $table->string('waterBlockingTapStandard_time', 100);
            $table->string('TDS_number_time', 100);
            $table->string('conductorWeightStandard_time', 100);
            $table->string('resistance_time', 100);
            $table->string('constructionStandard_time', 100);
            $table->string('layLengthStandard_time', 100);
            $table->string('powder_grease_weightStandard_time', 100);
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
        Schema::dropIfExists('strandingstandardstimes');
    }
}
