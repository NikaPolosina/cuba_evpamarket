<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();
Route::get('/', 'IndexController@Index');
Route::any('/find', [ 'as' => 'find', 'uses' => 'ProductsController@findProduct' ]);
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index' ]);
Route::post('/register-aditiona-info', 'Auth\AuthController@registerAditional');

/*----------------CompanyController--------------------*/
Route::get('/register-c', 'Auth\AuthController@registerC');
Route::any('/show-company/{id}', 'CompanyController@show');
Route::group(['middleware' => ['web']], function () {
    Route::resource('company', 'CompanyController');
});

/*----------------ProductController--------------------*/
Route::group(['middleware' => ['web']], function () {
    Route::resource('products', 'ProductsController');
    Route::get('/products/create/{company_id}', 'ProductsController@create');
});
Route::any('/get-product-list', 'ProductsController@getProductList');
Route::any('/products/destroy-check', 'ProductsController@destroyCheck');
Route::any('/products/create-by-category', 'ProductsController@createByCategory');
Route::any('/products-category', ['as' => 'products-category', 'uses' => 'ProductsController@storeCategory']);
Route::get('/get-product-paginate', ['as' => 'get-product-paginate', 'uses' => 'ProductsController@productPaginate']);
Route::get('/product-editor/{id}', 'ProductsController@productEditor');
Route::post('/products/edit-categoty', 'ProductsController@editCategory');
Route::post('/destroy', 'ProductsController@destroy');
Route::get('/single-product/{id}', 'ProductsController@singleProduct');
Route::post('/products/ajax-update', ['as'=>'product-ajax-update', 'uses'=>'ProductsController@productAjaxUpdate']);
Route::post('/attach-category-to-company', ['as'=>'attach-category-to-company', 'uses'=>'ProductsController@attachCategoryToCompany']);
Route::post('/attach-category-to-company', ['as'=>'attach-category-to-company', 'uses'=>'ProductsController@attachCategoryToCompany']);

Route::any('/products/show/', 'ProductsController@show');

/*-------------------------------------------User----------------------------------------------*/

Route::any('/user/simple_user/message', 'UserController@message');
Route::any('/user/simple_user/payments', 'UserController@payments');
Route::any('/user/simple_user/delivery', 'UserController@delivery');
Route::any('/user/simple_user/liked', 'UserController@liked');
Route::any('/user/simple_user/basket', 'UserController@basket');
Route::any('/user/simple_user/setting', 'UserController@setting');
Route::any('/user/simple_user/setting/overall', 'UserController@settingOverall');
Route::any('/user/simple_user/setting/security', 'UserController@settingSecurity');
Route::any('/user/simple_user/setting/security/edit', 'UserController@settingOverallEdit');

/*-------------------------------------------Category----------------------------------------------*/
Route::get('/care', ['as' => 'care', 'uses' => 'CategoryController@care']);
Route::get('/sports', ['as' => 'sports', 'uses' => 'CategoryController@sports']);
Route::get('/weddings', ['as' => 'weddings', 'uses' => 'CategoryController@weddings']);
Route::get('/celebrations', ['as' => 'celebrations', 'uses' => 'CategoryController@celebrations']);
Route::get('/animals', ['as' => 'animals', 'uses' => 'CategoryController@animals']);
Route::get('/entertainment', ['as' => 'entertainment', 'uses' => 'CategoryController@entertainment']);




Route::any('category/category-setup/{id}', 'CategoryController@categorySetup');



Route::get('/get-city-by-region/{id}', 'LocationController@getCityByRegion');

Route::get('/test', ['uses'=>'HomeController@test']);
Route::get('/homeSimpleUser', function(){
    return view('homeSimpleUser');
});
Route::get('/homeOwnerUser', ['as'=>'homeOwnerUser', 'uses'=>'HomeController@registerOwner'] );
Route::any('/file-uploader', ['as'=>'file_uploader', 'uses'=>'FileController@index']);







