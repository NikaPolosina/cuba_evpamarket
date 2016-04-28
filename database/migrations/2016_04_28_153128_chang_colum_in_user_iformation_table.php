<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangColumInUserIformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('user_informations', function ($table) {
            $table->renameColumn('location', 'country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('user_informations', function ($table) {
            $table->renameColumn('country', 'location');
        });
    }
}
