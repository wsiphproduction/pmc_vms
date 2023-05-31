<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRequestCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_request_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('request_id')->nullable();
            $table->string('username',100)->nullable();
            $table->dateTime('AddedAt')->nullable();
            $table->string('comment',1000)->nullable();
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
        Schema::dropIfExists('vehicle_request_comments');
    }
}
