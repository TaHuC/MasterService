<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealTimeUserChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_time_user_checks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->integer('realTimeServiceId')->unsigned();
            $table->foreign('realTimeServiceId')->references('id')->on('real_time_services');
            $table->boolean('service')->default(false);
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
        Schema::dropIfExists('real_time_user_checks');
    }
}
