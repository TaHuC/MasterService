<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientId')->unsigned();
            $table->foreign('clientId')->references('id')->on('clients');
            $table->integer('typeId')->unsigned();
            $table->foreign('typeId')->references('id')->on('types');
            $table->integer('brandId')->unsigned();
            $table->foreign('brandId')->references('id')->on('brands');
            $table->integer('modelId')->unsigned();
            $table->foreign('modelId')->references('id')->on('models');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->string('serial');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('products');
    }
}
