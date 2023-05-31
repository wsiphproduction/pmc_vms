<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masters', function (Blueprint $table) {
            $table->float('No#')->nullable();
            $table->string('BRAND/MAKE',255)->nullable();
            $table->string('MODEL',255)->nullable();
            $table->string('TYPE',255)->nullable();
            $table->string('EQUIPMENT',255)->nullable();
            $table->string('COLOR',255)->nullable();
            $table->string('PLATE No#',255)->nullable();
            $table->string('ENGINE/SERIAL NO#',255)->nullable();
            $table->string('CHASSIS NO#',255)->nullable();
            $table->string('ODOMETER',255)->nullable();
            $table->string('AV #',255)->nullable();
            $table->string('USER/DRIVER',255)->nullable();
            $table->string('LOCATION/DEPARTMENT',255)->nullable();
            $table->string('STATUS',255)->nullable();
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
        Schema::dropIfExists('masters');
    }
}
