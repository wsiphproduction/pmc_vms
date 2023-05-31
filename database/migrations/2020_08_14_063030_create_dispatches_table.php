<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch', function (Blueprint $table) {
            $table->id();
            $table->integer('unitId')->nullable();
            $table->string('type',50)->nullable();
            $table->string('deptId',200)->nullable();
            $table->dateTime('dateStart')->nullable();
            $table->dateTime('dateEnd')->nullable();
            $table->text('purpose')->nullable();
            $table->string('addedBy',50)->nullable();
            $table->dateTime('addedDate')->nullable();
            $table->string('tripTicket',20)->nullable();
            $table->string('destination',150)->nullable();
            $table->text('passengers')->nullable();
            $table->decimal('odometer_start',16,2)->nullable();
            $table->decimal('odometer_end',16,2)->nullable();
            $table->decimal('fuel_consumption',16,2)->nullable();
            $table->decimal('fuel_added_qty',16,2)->nullable();
            $table->string('fuel_added_type',150)->nullable();
            $table->integer('request_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->string('Cancelled_by',100)->nullable();
            $table->dateTime('Cancelled_at')->nullable();
            $table->string('Closed_by',100)->nullable();
            $table->dateTime('Closed_at')->nullable();
            $table->string('Status',100)->nullable();
            $table->integer('isPrinted')->nullable();
            $table->string('RQ',100)->nullable();
            $table->string('itemCode',255)->nullable();
            $table->string('uom',255)->nullable();
            $table->decimal('fuel_requested_qty',16,2)->nullable();
            $table->integer('numberOfTrips')->nullable();
            $table->string('vehicle_cost_code',255)->nullable();
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
        Schema::dropIfExists('dispatch');
    }
}
