<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestOtherInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_other_info', function (Blueprint $table) {
            $table->id();   
            $table->integer('request_id')->nullable();
            $table->string('contact_person',150)->nullable();
            $table->string('designation',150)->nullable();
            $table->string('dept',150)->nullable();
            $table->string('contact_no',150)->nullable();
            $table->string('delivery_site',150)->nullable();
            $table->text('other_instructions')->nullable();
            $table->string('pickup_dept',150)->nullable();
            $table->text('pickup_location')->nullable();
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
        Schema::dropIfExists('request_other_info');
    }
}
