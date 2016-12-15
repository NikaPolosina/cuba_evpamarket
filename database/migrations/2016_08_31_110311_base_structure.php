<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseStructure extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        //Create table for regions
        Schema::create('regions', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->integer('id_region')->unsigned()->unique();
            $table->timestamps();
        });
        //Create table for cities
        Schema::create('cities', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_cities')->unsigned()->unique();
            $table->integer('region_id')->unsigned();
            $table->string('title_cities');
            $table->timestamps();
            $table->foreign('region_id')->references('id_region')->on('regions')->onUpdate('cascade')->onDelete('cascade');
        });
        //Create table for category
        Schema::create('category', function (Blueprint $table){
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('title');
            $table->boolean('vip')->default(0);
            $table->string('icon');
            $table->string('img');
            $table->timestamps();
        });
        //Create table for users
        Schema::create('users', function (Blueprint $table){
            $table->increments('id');
            $table->string('email')->unique();
            $table->char('phone', 15)->unique();
            $table->boolean('active')->default(1);
            $table->boolean('block')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        //Create table for password_resets
        Schema::create('password_resets', function (Blueprint $table){
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table){
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->primary([
                'user_id',
                'role_id'
            ]);
        });
        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table){
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table){
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->primary([
                'permission_id',
                'role_id'
            ]);
        });
        //Create table for companies
        Schema::create('companies', function (Blueprint $table){
            $table->increments('id');
            $table->string('company_name');
            $table->text('company_description');
            $table->string('company_logo');
            $table->text('company_content');
            $table->text('country');
            $table->integer('region_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('street');
            $table->string('address');
            $table->text('company_contact_info');
            $table->longText('company_additional_info');
            $table->boolean('block')->default(0);
            $table->timestamps();
            //$table->foreign('region_id')->references('id')->on('regions');
            //$table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('region_id')->references('id_region')->on('regions');//->onUpdate('cascade')->onDelete('set null');
            $table->foreign('city_id')->references('id_cities')->on('cities')->onUpdate('cascade')->onDelete('set null');
        });
        //Create table for company_user
        Schema::create('company_user', function (Blueprint $table){
            $table->integer('company_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        //Create table status product (Создаем таблицу статусов по продуктам с именем status_product).
        Schema::create('status_product', function (Blueprint $table){
            $table->increments('id');
            $table->string('status_key');
            $table->string('status_name');
            $table->boolean('visible_admin');
            $table->boolean('visible_seller');
            $table->boolean('visible_buyer');
            $table->timestamps();
        });
        //Create table for products
        Schema::create('products', function (Blueprint $table){
            $table->increments('id');
            $table->string('product_name');
            $table->integer('category_id')->unsigned();
            $table->text('product_description');
            $table->text('content');
            $table->string('product_image');
            $table->string('product_price')->nullable();
            $table->string('min_price')->nullable();
            $table->string('max_price')->nullable();
            $table->longText('value')->default('');
            $table->string('status_product');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('category');
            /*$table->foreign('status_product')->references('status_key')->on('status_product');*/
        });
        //Create table for additional_param
        Schema::create('additional_param', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('key');
            $table->string('description');
            $table->string('placeholder');
            $table->string('type');
            $table->string('type_for_by');
            $table->boolean('required');
            $table->boolean('request_buyer');
            $table->float('sort');
            $table->string('default');
            $table->boolean('request');
            $table->text('value');
            $table->timestamps();
        });
        //Create table for product_additional_param
        Schema::create('additional_param_category', function (Blueprint $table){
            $table->integer('category_id')->unsigned();
            $table->integer('additional_param_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('additional_param_id')->references('id')->on('additional_param')->onDelete('cascade');
        });
        //Create table for company-product
        Schema::create('company_product', function (Blueprint $table){
            $table->integer('company_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        //Create table for user_informations
        Schema::create('user_informations', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('surname');
            $table->string('avatar');
            $table->date('date_birth');
            $table->boolean('gender');
            $table->string('country');
            $table->integer('region_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('street');
            $table->string('address');
            $table->text('about_me');
            $table->string('my_site');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('region_id')->references('id_region')->on('regions')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('city_id')->references('id_cities')->on('cities')->onUpdate('cascade')->onDelete('set null');
        });
        //Create table for category_company
        Schema::create('category_company', function (Blueprint $table){
            $table->integer('category_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->primary([
                'category_id',
                'company_id'
            ]);
            /*$table->integer('category_id');
            $table->integer('company_id');
            $table->timestamps();*/
        });
        //Create table for user_product
        Schema::create('user_product', function (Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        //Create table for status_simple
        Schema::create('status_simple', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
        //Create table for status_owner
        Schema::create('status_owner', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('key');
            $table->integer('status_simple_id')->unsigned();
            $table->timestamps();
            $table->foreign('status_simple_id')->references('id')->on('status_simple');
        });
        //Create table for order
        Schema::create('order', function (Blueprint $table){
            $table->increments('id');
            $table->integer('simple_user_id')->unsigned();
            $table->integer('owner_user_id')->unsigned();
            $table->integer('status');
            $table->integer('total_price');
            $table->float('discount_price');
            $table->integer('percent');
            $table->string('order_phone');
            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('address');
            $table->string('name');
            $table->string('surname');
            $table->text('note');
            $table->boolean('hand')->default(false);
            $table->timestamps();
            $table->foreign('simple_user_id')->references('id')->on('users');
            $table->foreign('owner_user_id')->references('id')->on('users');
        });
        //Create table for product_order
        Schema::create('product_order', function (Blueprint $table){
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('cnt');
            $table->integer('price');
            $table->integer('order_id')->unsigned();
            $table->text('add_param');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('order');
        });
        //Create table for company_order
        Schema::create('company_order', function (Blueprint $table){
            $table->integer('company_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
        });
        //Create table for discount_accumulative
        Schema::create('discount_accumulative', function (Blueprint $table){
            $table->increments('id');
            $table->integer('from')->unsigned();
            $table->integer('percent')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
        });
        //Create table for user_money
        Schema::create('user_money', function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->float('money')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
        });
        //Create table for groups
        Schema::create('groups', function (Blueprint $table){
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('group_name');
            $table->float('money')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
        });
        //Create table for group_user
        Schema::create('group_user', function (Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->boolean('is_admin')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
        //Create table for messages_types
        Schema::create('messages_types', function (Blueprint $table){
            $table->increments('id');
            $table->string('key');
            $table->string('title');
        });
        //Create table for messages
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
        //Create table for member_group_history
        Schema::create('member_group_history', function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->float('money')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
        });
        //Create table for feedback_product
        Schema::create('feedback_product', function (Blueprint $table){
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('feedback');
            $table->integer('rating');
            $table->text('file');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('order');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
        });
        //Create table for addition_feedback
        Schema::create('addition_feedback', function (Blueprint $table){
            $table->increments('id');
            $table->integer('feed_id')->unsigned();
            $table->text('msg');
            $table->timestamps();
            $table->foreign('feed_id')->references('id')->on('feedback_product');
        });
        //Create table for chat_users
        Schema::create('chat_users', function (Blueprint $table){
            $table->increments('id');
            $table->integer('from_id')->unsigned();
            $table->integer('to_id')->unsigned();
            $table->text('type');
            $table->timestamps();
            $table->foreign('from_id')->references('id')->on('users');
            $table->foreign('to_id')->references('id')->on('users');
        });
        //Create table for chat_msgs
        Schema::create('chat_msgs', function (Blueprint $table){
            $table->increments('id');
            $table->integer('from_id')->unsigned();
            $table->integer('to_id')->unsigned();
            $table->text('body');
            $table->integer('chat_user_id')->unsigned();
            $table->timestamps();
            $table->foreign('from_id')->references('id')->on('users');
            $table->foreign('to_id')->references('id')->on('users');
            $table->foreign('chat_user_id')->references('id')->on('chat_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    //Реверсивное действие миграции (В данном случае идет удаление всех рание сзданных таблиц в таком порядке, что бы не возникло конфликтов).
    public function down(){
        Schema::drop('chat_msgs');
        Schema::drop('chat_users');
        Schema::drop('addition_feedback');
        Schema::drop('feedback_product');
        Schema::drop('member_group_history');
        Schema::drop('messages');
        Schema::drop('messages_types');
        Schema::drop('group_user');
        Schema::drop('groups');
        Schema::drop('user_money');
        Schema::drop('discount_accumulative');
        Schema::drop('company_order');
        Schema::drop('product_order');
        Schema::drop('order');
        Schema::drop('status_owner');
        Schema::drop('status_simple');
        Schema::drop('user_product');
        Schema::drop('category_company');
        Schema::drop('user_informations');
        Schema::drop('company_product');
        Schema::drop('products');
        Schema::drop('status_product');
        Schema::drop('company_user');
        Schema::drop('companies');
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
        Schema::drop('password_resets');
        Schema::drop('users');
        Schema::drop('additional_param_category');
        Schema::drop('additional_param');
        Schema::drop('category');
        Schema::drop('cities');
        Schema::drop('regions');
    }
}
