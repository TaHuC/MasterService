<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productId')->unsigned();
            $table->foreign('productId')->references('id')->on('products');
            $table->integer('statusId')->unsigned();
            $table->foreign('statusId')->references('id')->on('statuses');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->float('price')->default(0);
            $table->float('deposit')->default(0);
            $table->string('now');
            $table->string('problem');
            $table->string('password')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('orders');
    }
}
