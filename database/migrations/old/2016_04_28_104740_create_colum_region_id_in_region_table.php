<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumRegionIdInRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('regions', function($table)
        {
            $table->integer('id_region')->after('title');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('regions', function($table)
        {
            $table->dropColumn('id_region');
        });
    }
}
