<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration{

    public function up(){
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cities');
            $table->integer('region_id');
            $table->string('title_cities');
            $table->timestamps();
        });
    }


    public function down(){
        Schema::drop('cities');
    }
}
