<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumPersentAndPriceDiscountInOrderTanle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function(Blueprint $table){
            $table->float('discount_price')->after('total_price');
            $table->integer('percent')->after('discount_price');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function ($table) {
            $table->dropColumn('discount_price');
            $table->dropColumn('percent');

        });
    }
}
