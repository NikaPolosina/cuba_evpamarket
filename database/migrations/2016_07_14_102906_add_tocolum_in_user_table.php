<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTocolumInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_informations', function($table) {
            $table->text('about_me')->after('address');
            $table->string('my_site')->after('about_me');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_informations', function($table){
            $table->dropColumn('about_me');
            $table->dropColumn('my_site');
        });
    }
}
