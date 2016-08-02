<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('companies', function(Blueprint $table) {
                $table->increments('id');
                $table->string('company_name');
                $table->text('company_description');
                $table->string('company_logo');
                $table->text('company_content');
                $table->text('company_address');
                $table->text('company_contact_info');
                $table->longText('company_additional_info');

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
        Schema::drop('companies');
    }

}
