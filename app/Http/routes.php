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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();



Route::get('/register-company', 'Auth\AuthController@registerCompany');
Route::post('/register_company', 'Auth\AuthController@registerCompany');



Route::get('/home', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);



//Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['web']], function () {
	Route::resource('company', 'CompanyController');
});
Route::group(['middleware' => ['web']], function () {
	Route::resource('products', 'ProductsController');
    Route::get('/products/create/{company_id}', 'ProductsController@create');
});

