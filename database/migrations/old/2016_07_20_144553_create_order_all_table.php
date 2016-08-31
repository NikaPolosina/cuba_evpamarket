<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('status_simple', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
        Schema::create('status_owner', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('key');
            $table->integer('status_simple_id');
            $table->timestamps();
        });
        Schema::create('order', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('simple_user_id');
            $table->integer('owner_user_id');
            $table->integer('status');
            $table->integer('total_price');
            $table->string('order_phone');
            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('address');
            $table->string('name');
            $table->string('surname');
            $table->timestamps();
        });
        Schema::create('product_order', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('cnt');
            $table->integer('price');
            $table->integer('order_id');
            $table->timestamps();
        });

        Schema::create('company_order', function (Blueprint $table) {
            $table->integer('company_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade');
            $table->foreign('order_id')
                ->references('id')->on('order')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('status_simple');
        Schema::drop('status_owner');
        Schema::drop('order');
        Schema::drop('product_order');
        Schema::drop('company_order');
    }
}
