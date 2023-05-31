<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname',350)->nullable();
            $table->string('domain',150)->nullable();
            $table->integer('isLocked')->nullable();
            $table->dateTime('lockedOn')->nullable();
            $table->integer('isApprover')->nullable();
            $table->string('dept',150)->nullable();
            $table->string('role',150)->nullable();
            $table->integer('active')->nullable();
            $table->integer('isdepartment')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('dpassword',100)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
