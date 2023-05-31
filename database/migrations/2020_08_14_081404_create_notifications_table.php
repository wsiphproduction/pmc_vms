<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('to',150)->nullable();
            $table->string('from',150)->nullable();
            $table->text('message')->nullable();
            $table->dateTime('addedDate')->nullable();
            $table->integer('isNotified')->nullable();
            $table->integer('isViewed')->nullable();
            $table->string('title',250)->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
