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
Route::get('/', 'ProductsController@getProductAll');
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


Route::get('/file', function () {
 return view('file');
});

Route::get('/get-city-by-region/{id}', 'LocationController@getCityByRegion');

Route::get('/test', function(){
    return view('auth.register_aditional');
});
Route::get('/homeSimpleUser', function(){
    return view('homeSimpleUser');
});
Route::get('/homeOwnerUser', ['as'=>'homeOwnerUser', 'uses'=>'HomeController@registerOwner'] );
Route::any('/file-uploader', ['as'=>'file_uploader', 'uses'=>'FileController@index']);







