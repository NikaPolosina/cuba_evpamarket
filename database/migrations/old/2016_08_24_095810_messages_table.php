<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MessagesTable extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('messages', function (Blueprint $table){
            $table->increments('id');
            $table->integer('type');
            $table->integer('connected_id');
            $table->integer('status');
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();
            $table->string('subject');
            $table->string('body');
            $table->timestamps();
            
            $table->foreign('from')->references('id')->on('users');
            $table->foreign('to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('messages');
    }
}
