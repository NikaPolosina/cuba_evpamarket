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
            $table->string('order_address');
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
    }
}
