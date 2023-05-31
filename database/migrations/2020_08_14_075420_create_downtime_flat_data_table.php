<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDowntimeFlatDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downtimeFlatData', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('mins')->nullable();
            $table->integer('unitId')->nullable();
            $table->integer('isScheduled')->nullable();
            $table->integer('downtimeId')->nullable();
            $table->string('remarks',500)->nullable();
            $table->string('shop',100)->nullable();
            $table->string('downtimeCategory',150)->nullable();
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
        Schema::dropIfExists('downtimeFlatData');
    }
}
