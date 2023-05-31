<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDowntimeOldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downtime_old', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateStart')->nullable();
            $table->dateTime('dateEnd')->nullable();
            $table->string('remarks')->nullable();
            $table->string('addedBy',50)->nullable();
            $table->dateTime('addedDate')->nullable();
            $table->integer('unitId')->nullable();
            $table->integer('isScheduled')->nullable();
            $table->string('shop',100)->nullable();
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
        Schema::dropIfExists('downtime_old');
    }
}
