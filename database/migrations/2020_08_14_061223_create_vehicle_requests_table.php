<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_request', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->nullable();
            $table->string('dept',250)->nullable();
            $table->dateTime('date_needed')->nullable();
            $table->text('purpose')->nullable();
            $table->string('email',150)->nullable();
            $table->string('costcode',150)->nullable();
            $table->string('addedBy',100)->nullable();
            $table->dateTime('addedAt')->nullable();
            $table->string('refcode',50)->nullable();
            $table->string('origin',150)->nullable();
            $table->string('destination',150)->nullable();
            $table->string('status',50)->nullable();
            $table->string('updated_by',150)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('Cancelled_by',100)->nullable();
            $table->dateTime('Cancelled_at')->nullable();
            $table->string('Closed_by',100)->nullable();
            $table->dateTime('Closed_at')->nullable();
            $table->integer('isNotEditable')->nullable();
            $table->dateTime('lastStatusChanged')->nullable();
            $table->string('lastStatusChangedBy',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_request');
    }
}
