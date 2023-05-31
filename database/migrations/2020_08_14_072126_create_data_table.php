<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->string('WORK_ORDER',255)->nullable();
            $table->string('Vehicle_No#',255)->nullable();
            $table->string('Vehicle_Type',255)->nullable();
            $table->string('Downtime_Type',255)->nullable();
            $table->string('Repair_Type',255)->nullable();
            $table->string('Work_Details',255)->nullable();
            $table->string('Assigned_To',255)->nullable();
            $table->string('Mechanic_1',255)->nullable();
            $table->string('Mechanic_2',255)->nullable();
            $table->string('Mechanic_3',255)->nullable();
            $table->dateTime('Reported_Date')->nullable();
            $table->dateTime('Start_Date')->nullable();
            $table->dateTime('End_Date')->nullable();
            $table->dateTime('Start_Time')->nullable();
            $table->dateTime('End_Time')->nullable();
            $table->float('No# Crew')->nullable();
            $table->dateTime('Shop_Standby_Start_Time')->nullable();
            $table->float('No#_of_Hours_from_12AM')->nullable();
            $table->dateTime('Work_Start_Time')->nullable();
            $table->float('No#_of_Hours_from_7AM')->nullable();
            $table->string('Remarks',255)->nullable();
            $table->string('Status',255)->nullable();
            $table->float('Total_Repair_Days')->nullable();
            $table->float('Total_Repair_Hours')->nullable();
            $table->float('Total_Days_at_Shop')->nullable();
            $table->float('Total_Hours_at_Shop')->nullable();
            $table->float('Man_Hours')->nullable();
            $table->float('Required_Availability_per_Day')->nullable();
            $table->float('Downtime_for_Availability_Calculation')->nullable();
            $table->float('Availability_Period:YTD')->nullable();
            $table->float('Availability:Quarterly')->nullable();
            $table->float('Availability_Period:Monthly')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('downtime_type_id')->nullable();
            $table->string('mechanics',150)->nullable();
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
        Schema::dropIfExists('data');
    }
}
