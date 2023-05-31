<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',200)->nullable();
            $table->string('type',50)->nullable();
            $table->decimal('required_availability_hours',18,2)->nullable();
            $table->integer('active')->nullable();
            $table->string('dept',250)->nullable();
            $table->string('model',255)->nullable();
            $table->string('plateno',75)->nullable();
            $table->string('chassisno',255)->nullable();
            $table->string('engineno',255)->nullable();
            $table->string('color',75)->nullable();
            $table->integer('datasource')->nullable();
            $table->string('vehicle_code',50)->nullable();
            $table->integer('isECS')->nullable();
            $table->integer('odo_status')->default(0);

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
        Schema::dropIfExists('unit');
    }
}
