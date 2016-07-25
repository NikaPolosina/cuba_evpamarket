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

Route::get('/test', function()
{
    return view('test');
});


/*-------------------------------------------Index----------------------------------------------*/
Route::get('/', 'IndexController@Index');

/*-------------------------------------------Auth----------------------------------------------*/
Route::auth();
Route::get('/register-c', 'Auth\AuthController@registerC');
Route::post('/register-aditiona-info', 'Auth\AuthController@registerAditional');

/*-------------------------------------------Location----------------------------------------------*/
Route::get('/get-city-by-region/{id}', 'LocationController@getCityByRegion');

/*---------------------------------CompanyController------------------------------------*/
Route::any('/show-company/{id}', 'CompanyController@show');
Route::any('/company-content', ['as' => 'company-content', 'uses' => 'CompanyController@companyContent']);

Route::get('/my_shops', ['as' => 'my_shops', 'uses' => 'CompanyController@getMyShop']);

Route::group(['middleware' => ['web']], function () {
    Route::resource('company', 'CompanyController');
});

/*------------------------------------------ProductController---------------------------------------------*/
Route::group(['middleware' => ['web']], function () {
    Route::resource('products', 'ProductsController');
    Route::get('/products/create/{company_id}', 'ProductsController@create');
});
Route::any('/get-product-list', 'ProductsController@getProductList');
Route::any('/products/show/', 'ProductsController@show');
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

/*-------------------------------------------User----------------------------------------------*/
Route::any('/user/simple_user/message', 'UserController@message');
Route::any('/user/simple_user/payments', 'UserController@payments');
Route::any('/user/simple_user/delivery', 'UserController@delivery');
Route::any('/user/simple_user/liked', 'UserController@liked');
Route::any('/user/simple_user/basket', 'UserController@basket');
Route::any('/user/simple_user/setting', 'UserController@setting');
Route::any('/user/simple_user/setting/overall', 'UserController@settingOverall');
Route::any('/user/simple_user/setting/security', 'UserController@settingSecurity');
Route::any('/user/simple_user/setting/security/edit-simple', 'UserController@settingOverallEditSimple');
Route::post('/user/simple_user/setting/security/edit-owner', 'UserController@settingOverallEditOwner');

/*-------------------------------------------Category----------------------------------------------*/
Route::any('category/category-setup/{id}', 'CategoryController@categorySetup');
Route::post('/category/edit-categoty', ['as' => 'attach_categories', 'uses'=>'CategoryController@attachCategoriesToCompany']);
Route::post('/category/edit-categoty_two', ['as' => 'attach_categories_two', 'uses'=>'CategoryController@attachCategoriesToCompanyTwo']);


Route::post('/category/remove-categoty', ['as' => 'remove_categories', 'uses'=>'CategoryController@detachCategoriesToCompany']);



/*-------------------------------------------File--Uploader--------------------------------------------*/
Route::any('/file-uploader', ['as'=>'file_uploader', 'uses'=>'FileController@index']);
Route::any('/avatar-uploader', 'UserController@createAvatar');

/*-------------------------------------------Cart----------------------------------------------*/
Route::any('/cart', 'CartController@index');
Route::any('/cart/destroy-product', 'CartController@destroy');
Route::post('/products/cart', 'CartController@cart');
Route::post('/products/cart-update-cnt', 'CartController@cartAddCnt');

/*-------------------------------------------Like----------------------------------------------*/
Route::any('/like', 'LikeController@index');
Route::post('/products/like', 'LikeController@like');
Route::any('/like/destroy-product', 'LikeController@destroy');

/*-------------------------------------------Find----------------------------------------------*/
Route::any('/find', [ 'as' => 'find', 'uses' => 'FindController@findProduct' ]);
Route::get('/find/category/{id}', 'FindController@findByCategory');

/*-------------------------------------------Admin----------------------------------------------*/
Route::group([ 'prefix' => 'admin', 'middleware' => [ 'role:admin'] ], function (){
    Route::get('/', ['as' => 'admin', 'uses'=>'AdminController@index']);
    Route::get('/user', ['as' => 'admin', 'uses'=>'AdminController@allUser']);
    Route::get('/user-man', ['as' => 'admin', 'uses'=>'AdminController@userMan']);
    Route::get('/user-women', ['as' => 'admin', 'uses'=>'AdminController@userWomen']);
    Route::get('/user-blocked', ['as' => 'admin', 'uses'=>'AdminController@userBlocked']);
    Route::get('/shop-all', ['as' => 'admin', 'uses'=>'AdminController@shopAll']);
    Route::get('/shop-block', ['as' => 'admin', 'uses'=>'AdminController@shopBlocked']);
    Route::get('/category', ['as' => 'admin', 'uses'=>'AdminController@category']);
    Route::get('/category-add', ['as' => 'admin', 'uses'=>'AdminController@categoryAdd']);
    Route::post('/add-category-list', ['as' => 'admin', 'uses'=>'AdminController@categoryAddList']);
    Route::post('/add-item', ['as' => 'admin', 'uses'=>'AdminController@categoryAddItem']);
    Route::post('/user-block', ['as' => 'admin', 'uses'=>'AdminController@userBlock']);
});

/*-------------------------------------------Home--------------------------------------------*/

Route::get('/login-user', ['as' => 'login-user', 'uses' => 'HomeController@Index' ]);

Route::group([ 'middleware' => [ 'role:simple_user'] ], function (){
    Route::get('/homeSimpleUser', ['as' => 'homeSimpleUser', 'uses' => 'HomeController@registerSimple' ]);

});

Route::group([ 'middleware' => [ 'role:company_owner'] ], function (){
    Route::get('/homeOwnerUser', ['as'=>'homeOwnerUser', 'uses'=>'HomeController@registerOwner'] );
});

Route::post('/new-user-dashboard', ['as'=>'set_user_role', 'uses'=>'UserController@setRole']);

/*-------------------------------------------Order--------------------------------------------*/
Route::post('/order', [ 'as' => 'order', 'uses' => 'OrderController@createOrder' ]);
Route::post('/order-ready', [ 'as' => 'order-ready', 'uses' => 'OrderController@ready' ]);

Route::get('/show-order/{id}', 'OrderController@showOrder');
Route::get('/change-order-status/{order}/{status}', ['as'=>'change_order_status', 'uses'=>'OrderController@changStatus']);

/*---------------------------------------Status----------------------------------*/



