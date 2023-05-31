<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loginattempts', function (Blueprint $table) {
            $table->id();
            $table->string('Username',50);
            $table->integer('Attempts');
            $table->dateTime('LastLogin');
            $table->integer('status')->nullable();
            $table->string('statusName')->nullable();
            $table->dateTime('updateDate')->nullable();
            $table->string('computer')->nullable();
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
        Schema::dropIfExists('loginattempts');
    }
}
