<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costcodes', function (Blueprint $table) {
            $table->string('FULL_JOB_CODE',255)->nullable();
            $table->string('JOB_CODE',255)->nullable();
            $table->string('JOB_DESC',255)->nullable();
            $table->string('PHASE_CODE',255)->nullable();
            $table->string('PHASE_DESC',255)->nullable();
            $table->string('REQ_CODE',255)->nullable();
            $table->string('REQ_CODE_desc',255)->nullable();
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
        Schema::dropIfExists('cost_codes');
    }
}
