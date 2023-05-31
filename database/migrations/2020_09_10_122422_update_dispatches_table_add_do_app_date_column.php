<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDispatchesTableAddDoAppDateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dispatch', function (Blueprint $table) {
            $table->dateTime('do')->nullable();
            $table->dateTime('app_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dispatch', function (Blueprint $table) {
            $table->dropColumn('do');
            $table->dropColumn('app_date');
        });
    }
}
