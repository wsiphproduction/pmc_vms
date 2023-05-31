<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDowntimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downtime', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateStart')->nullable();
            $table->dateTime('dateEnd')->nullable();
            $table->string('remarks',255)->nullable();
            $table->string('addedBy',50)->nullable();
            $table->dateTime('addedDate')->nullable();
            $table->string('unitId')->nullable();
            $table->integer('isScheduled')->nullable();
            $table->string('shop')->nullable();
            $table->string('workOrder')->nullable();
            $table->string('repairType')->nullable();
            $table->text('workDetails')->nullable();
            $table->string('mechanics')->nullable();
            $table->date('reportedDate')->nullable();
            $table->string('status')->nullable();
            $table->decimal('from12',10,2)->nullable();
            $table->decimal('from7',10,2)->nullable();
            $table->decimal('trepair_days',10,2)->nullable();
            $table->decimal('trepair_hours',10,2)->nullable();
            $table->decimal('shop_days',10,2)->nullable();
            $table->decimal('shop_hours',10,2)->nullable();
            $table->decimal('man_hours',10,2)->nullable();
            $table->decimal('required_daily_availability',10,2)->nullable();
            $table->decimal('tdowntime',10,2)->nullable();
            $table->string('assignedTo',150)->nullable();
            $table->integer('active')->nullable();
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
        Schema::dropIfExists('downtime');
    }
}
