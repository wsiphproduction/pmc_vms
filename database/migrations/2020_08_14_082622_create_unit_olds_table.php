<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitOldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_old', function (Blueprint $table) {
            $table->id();
            $table->string('location',50)->nullable();
            $table->string('brand',100)->nullable();
            $table->string('model',100)->nullable();
            $table->string('type',100)->nullable();
            $table->string('equipment',100)->nullable();
            $table->string('plateNo',100)->nullable();
            $table->string('engineNo',100)->nullable();
            $table->string('chassisNo',100)->nullable();
            $table->string('odometer',100)->nullable();
            $table->string('avNo',100)->nullable();
            $table->string('driver',100)->nullable();
            $table->string('color',100)->nullable();
            $table->string('status',100)->nullable();
            $table->integer('isDisabled')->nullable();
            $table->string('locationType',50)->nullable();
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
        Schema::dropIfExists('unit_old');
    }
}
