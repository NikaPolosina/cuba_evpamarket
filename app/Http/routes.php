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

Route::any('/test/{run?}', 'IndexController@test');

Route::any('/test-my', 'TestController@myTest');

//Входная точка сайта. КОРЕНЬ
Route::get('/', 'IndexController@Index');

/*-------------------------------------------Auth----------------------------------------------*/
Route::auth();
Route::get('/register-c', 'Auth\AuthController@registerC');
Route::post('/register-aditiona-info', 'Auth\AuthController@registerAditional');

/*-------------------------------------------Location----------------------------------------------*/
Route::get('/get-city-by-region/{id}', 'LocationController@getCityByRegion');

/*---------------------------------CompanyController------------------------------------*/
//Просмотр компании пользователем.
Route::any('/show-company/{id}', 'CompanyController@show');
//Для создания дополнительной информации о компании.
Route::any('/company-content', ['as' => 'company-content', 'uses' => 'CompanyController@companyContent']);

Route::get('/my_shops', ['as' => 'my_shops', 'uses' => 'CompanyController@getMyShop']);
Route::get('/company-discount-setup/{id}', ['as' => 'company-discount-setup', 'uses' => 'CompanyController@setupDiscount']);
Route::post('/company-create-discount/{id}', ['as' => 'company-create-discount', 'uses' => 'CompanyController@createDiscount']);
Route::post('/company-destroy-discount/{company_id}/{discount_id}', ['as' => 'company-destroy-discount', 'uses' => 'CompanyController@destroyDiscount']);
/*
Route::get('/company-create-view', ['as' => 'company-create-view', 'uses' => 'CompanyController@create']);*/
Route::get('company/{id}/edit', 'CompanyController@edit');
Route::patch('company-create-single/{id}', 'CompanyController@update');
Route::get('/company/create', ['as' => 'company-create', 'uses' => 'CompanyController@create']);
Route::get('/company-done-create', ['as' => 'company-done-create', 'uses' => 'CompanyController@store']);
Route::post('/company-done-create', ['as' => 'company-done-create', 'uses' => 'CompanyController@store']);
Route::post ('company-delete/{id}', 'CompanyController@destroy');

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
//При нажатии на свой магазин в кабинете продавца. Просмотр свого магазина.Список товаров, категорий и статистика.
Route::get('/product-editor/{id}', 'ProductsController@productEditor');
Route::post('/products/edit-categoty', 'ProductsController@editCategory');
//Удаление продукта.
Route::post('/product/destroy', 'ProductsController@destroy');
//Просмотр товара пользователем (описание товара);
Route::get('/single-product/{id}', 'ProductsController@singleProduct');
//Просмотр соьственного товара продавцом.
Route::get('/single-product-my-shop/{id}', 'ProductsController@singleProductMyShop');
//Редактирование товара с помощу ajax.
Route::post('/products/ajax-update', ['as'=>'product-ajax-update', 'uses'=>'ProductsController@productAjaxUpdate']);
//страница где можно присоединить категории к компании.
Route::post('/attach-category-to-company', ['as'=>'attach-category-to-company', 'uses'=>'ProductsController@attachCategoryToCompany']);
//При нажатии пользователем кнопки купить. Добавление товара в корзину. Для того что бы появилось модальное окно.
Route::post('/products/ajax-single-product',['as'=>'ajax_single_product', 'uses'=>'ProductsController@ajaxSingleProduct']);

Route::get('/product/ajax-to-cart-add-param/{id}',['as'=>'ajax_single_product_add_param_chose', 'uses'=>'ProductsController@ajaxSingleProductAdd']);



Route::get('/product-form/{companyId}/{categoryId?}/{productId?}', ['as'=>'product_form', 'uses'=>'ProductsController@productForm']);


Route::match(['post', 'patch'], '/save-product', ['as'=>'save_product_form', 'uses'=>'ProductsController@saveProductForm']);


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
Route::get('/show-user/{id}', 'UserController@getUserPage');

/*-------------------------------------------Category----------------------------------------------*/
Route::any('category/category-setup/{id}', 'CategoryController@categorySetup');
Route::post('/category/edit-categoty', ['as' => 'attach_categories', 'uses'=>'CategoryController@attachCategoriesToCompany']);
Route::post('/category/edit-categoty_two', ['as' => 'attach_categories_two', 'uses'=>'CategoryController@attachCategoriesToCompanyTwo']);
Route::post('/category/remove-categoty', ['as' => 'remove_categories', 'uses'=>'CategoryController@detachCategoriesToCompany']);

//При создании продукта, выбираются дополнительные параметры которые нужно указать продавцом.
Route::any('/get-add-param/{id}', ['as' => 'get-add-param', 'uses'=>'CategoryController@getAddParamFromCategory']);


/*-------------------------------------------File--Uploader--------------------------------------------*/
Route::any('/file-uploader', ['as'=>'file_uploader', 'uses'=>'FileController@index']);
Route::any('/avatar-uploader', 'UserController@createAvatar');

/*-------------------------------------------Cart----------------------------------------------*/
Route::any('/cart', ['as'=>'cart', 'uses'=>'CartController@index']);
Route::any('/cart/destroy-product', 'CartController@destroy');
Route::post('/products/cart', 'CartController@cart');

Route::post('/products/ajax_cart', ['as'=>'ajax_add_to_cart', 'uses'=>'CartController@ajaxCart']);

Route::post('/products/cart-update-cnt', 'CartController@cartAddCnt');

/*-------------------------------------------Like----------------------------------------------*/
//Избранное (при нажатии на картинку - сердце).
Route::any('/like', 'LikeController@index');
//Добавление товара в избранное при нажатии на картинку - серце у товара.
Route::post('/products/like', 'LikeController@like');
//Для удаления товара из списка избранного.
Route::any('/like/destroy-product', 'LikeController@destroy');

/*-------------------------------------------Find----------------------------------------------*/
//Поиск товаров по сайту.
Route::any('/find', [ 'as' => 'find', 'uses' => 'FindController@findProduct' ]);
//Поиск пользователя если тот был зарегестрированный по номеру телефона.
Route::post('/find-user-by-number', [ 'as' => 'find-user-by-number', 'uses' => 'FindController@findUserByNumber' ]);
//Найти товары по данной категории.
Route::get('/find/category/{id}', 'FindController@findByCategory');

/*-------------------------------------------Админка    ----------------------------------------------*/
Route::group([ 'prefix' => 'admin', 'middleware' => [ 'role:admin'] ], function (){
    //Переход на домашнюю сраницу админа.
    Route::get('/', ['as' => 'admin', 'uses'=>'AdminController@index']);
    //Список всех пользователей зарегестрированных в системе.
    Route::get('/user', ['as' => 'admin', 'uses'=>'AdminController@allUser']);
    //Список всех поьзователей мужского пола.
    Route::get('/user-man', ['as' => 'admin', 'uses'=>'AdminController@userMan']);
    //Список всех поьзователей женского пола.
    Route::get('/user-women', ['as' => 'admin', 'uses'=>'AdminController@userWomen']);
    //Блокирование юзера.
    Route::post('/user-block', ['as' => 'admin', 'uses'=>'AdminController@userBlock']);
    //Список всех поьзователей которые были заблокированные.
    Route::get('/user-blocked', ['as' => 'admin', 'uses'=>'AdminController@userBlocked']);
    //Спысок всех магазинов зарегестрированных в системе.
    Route::get('/shop-all', ['as' => 'admin', 'uses'=>'AdminController@shopAll']);
    //Список всех заблокированных магазинов.
    Route::get('/shop-block', ['as' => 'admin', 'uses'=>'AdminController@shopBlocked']);
    //Список дополнительных параметров товаров.
    Route::get('/addition-param-list', ['as' => 'admin', 'as'=>'addition_param_list', 'uses'=>'AdminController@AdditionParamList']);
    //Форма создания нового дополнительного параметра.
    Route::get('/addition-param-add/{id?}', ['as' => 'additional_param', 'uses'=>'AdminController@additionParamAdd']);
    //Создания дополнительного параметра по товару.
    Route::match(['post', 'patch'], '/create-add-param', ['as' => 'admin_create_additional_param', 'uses'=>'AdminController@createAddParam']);
    //Просмотра дополнительного параметра. Принимает $id.
    Route::get('/show-add-param/{id}', ['as' => 'admin', 'uses'=>'AdminController@AdditionParamShowItem']);
    //Удаление дополнительного параметра по товару.
    Route::get('/add-param-destroy/{id}', ['as' => 'admin', 'uses'=>'AdminController@destroyAddParam']);
    //Переход на страницу просмотра и добавления дополнительных параметров описания товара по категории.
    Route::match(['get', 'post'], '/category-param/{id}', ['as' => 'admin', 'uses'=>'AdminController@addCategoryAddParam']);
    //Список всех категорий.
    Route::get('/category', ['as' => 'admin', 'uses'=>'AdminController@category']);
    //Переход на форму создания новой категории товара.
    Route::get('/category-add', ['as' => 'admin', 'uses'=>'AdminController@categoryAdd']);
    //Создание категории.
    Route::post('/add-item', ['as' => 'admin', 'uses'=>'AdminController@categoryAddItem']);
    //Удаление категори.
    Route::get('/category-destroy/{id}', ['as' => 'admin', 'uses'=>'AdminController@categoryDestroy']);
    //Редактирование категории.
    Route::post('/category-update', ['as' => 'admin', 'uses'=>'AdminController@categoryUpdate']);
    //При изменении родительской категории идет перезапрос в базу для того что бы вять детей категории.
    Route::post('/add-category-list', ['as' => 'admin', 'uses'=>'AdminController@categoryAddList']);
    //Список всех регионов.
    Route::get('/region-list', ['as' => 'admin', 'uses'=>'AdminController@regionList']);
    //Просмотр региона.
    Route::get('/single-region/{id}', ['as' => 'admin', 'uses'=>'AdminController@regionSingle']);
    //Удаление города.
    Route::get('/city-destroy/{id}', ['as' => 'admin', 'uses'=>'AdminController@cityDestroy']);
    //Редактирование города.
    Route::post('/city-update', ['as' => 'admin', 'uses'=>'AdminController@cityUpdate']);
    //Статистика по компании.
    Route::get('/company_statistic/{id}', ['as' => 'admin', 'uses'=>'AdminController@shopStatistic']);

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
//Форма заказа товара.
Route::post('/order', [ 'as' => 'order', 'uses' => 'OrderController@createOrder' ]);
//Заказ товара.
Route::post('/order-ready', [ 'as' => 'order-ready', 'uses' => 'OrderController@ready' ]);
//Просмотр заказа
Route::get('/show-order/{id}', 'OrderController@showOrder');

Route::get('/change-order-status/{order}/{status}', ['as'=>'change_order_status', 'uses'=>'OrderController@changStatus']);
//Просмотр единичного заказа(просмотр деталей заказа) покупателем. Принимает id заказа.
Route::get('/show-simple-order/{id}', ['as'=>'show-simple-order', 'uses'=>'OrderController@showSimpleOrder']);
//Просмотр списка закзав сделанных покупателем.
Route::get('/show-list-order-simple', ['as'=>'show-list-order-simple', 'uses'=>'OrderController@showSimpleOrderList']);

//Регистрация заказа пользователя в ручном режиме (регестрирует продавец у сея в кабинете) (принимат id пользователя-покупателя)
Route::get('/add-handle-order/{id}/{shop}', ['as'=>'add-handle-order', 'uses'=>'OrderController@orderRegistrHandle']);

//Оформление заказа в ручную.
Route::any('/order-ready-handle/{id?}', ['as'=>'order-ready-handle', 'uses'=>'OrderController@orderHandleReady']);





/*---------------------------------------Status----------------------------------*/
//Изменение статуса по заказу продавцом.
Route::get('/change-order-status/{order}/{status}', ['as'=>'change_order_status', 'uses'=>'OrderController@changStatus']);
//Список заказав который видит подавец по своему магазину с возможностью изменить статус заказа и списком статусов которые у него активные.
Route::any('/order-by-status/{company}/{status}', ['as'=>'order-by-status', 'uses'=>'OrderController@showOrder']);

// Groups
//Список групп пользователя
Route::get('/show-group-list', ['as'=>'show-group-list', 'uses'=>'GroupController@showGroupList']);

Route::post('/group-create', ['as'=>'group-create', 'uses'=>'GroupController@createGroup']);
Route::get('/single-group/{id}', 'GroupController@showSingleGroup');
Route::post('/group/send-invite', ['as'=>'group_invite_action', 'uses'=>'GroupController@ajaxInviteToGroup']);

Route::get('/disable-invite/{id}', ['as'=>'disable_group_invite', 'uses'=>'GroupController@disableInvite']);
Route::get('/enable-invite/{id}', ['as'=>'enable_group_invite', 'uses'=>'GroupController@enableInvite']);

Route::post('/group-destroy/{id}', ['as'=>'group-destroy', 'uses'=>'GroupController@destroy']);
Route::post('/group-left/{id}', ['as'=>'group-left', 'uses'=>'GroupController@left']);

Route::post('/user/advanced_ajax_search', ['as'=>'advanced_ajax_search', 'uses'=>'UserController@ajaxAdvancedSearch']);
/*---------------------------------------------feedback------------------------------------------------------------------*/
Route::get('/feedback-view/{id}', ['as'=>'feedback-view', 'uses'=>'FeedbackController@start']);
Route::post('/feedback-view/{id}', ['as'=>'feedback-view', 'uses'=>'FeedbackController@startSetup']);
Route::get('/show-my-feed/{product_id}/{order_id}/{user_id}', ['as'=>'show-my-feed', 'uses'=>'FeedbackController@showMyFeed']);
Route::post('/add-ajax-change-feed', ['as'=>'add-ajax-change-feed', 'uses'=>'FeedbackController@editFeed']);
Route::post('/add-ajax-addition-feed', ['as'=>'add-ajax-addition-feed', 'uses'=>'FeedbackController@additionFeed']);


/*-----------------------------------------------------------chat------------------------------------------------------------*/
Route::get('/get-single-conversation/{id_from}/{id_to}', ['as'=>'get-single-conversation', 'uses'=>'HomeController@getUserPageWithConversationUsers']);


Route::group(['middleware' => 'cors'], function(){
    Route::get('/who-am-i/{id}', ['as'=>'who_am_i', 'uses'=>'IndexController@whoAmI']);
    Route::post('/save-chat', ['as'=>'save_chat', 'uses'=>'IndexController@saveChat']);
    Route::get('/chat-history/{conversation}/{page}', ['as'=>'chat_history', 'uses'=>'IndexController@chatHistory']);
});









