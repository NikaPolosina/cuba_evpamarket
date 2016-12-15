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
//При нажатии в кабинете продавца на (Мои заказы) - попадаем на список магазинов где светятся не просмотренные заказы по каждому магазину.
Route::get('/my_shops', ['as' => 'my_shops', 'uses' => 'CompanyController@getMyShop']);
//Роут для перехода на страницу установки накопительных скидок продавцом. Принимает id магазина.
Route::get('/company-discount-setup/{id}', ['as' => 'company-discount-setup', 'uses' => 'CompanyController@setupDiscount']);
//Роут для создания дисконта(накопительных скидок).
Route::post('/company-create-discount/{id}', ['as' => 'company-create-discount', 'uses' => 'CompanyController@createDiscount']);
//Роут для удаления дисконтных скидок продавцом.(Принимает id-магазина и id дисконтной скидки.)
Route::post('/company-destroy-discount/{company_id}/{discount_id}', ['as' => 'company-destroy-discount', 'uses' => 'CompanyController@destroyDiscount']);
//РОут что направлят на форму редактирования информации о компании (магазину).
Route::get('company/{id}/edit', 'CompanyController@edit');
//Сохраняет отредактированные даные по компании (магазину) принимает id-магазина.
Route::patch('company-create-single/{id}', 'CompanyController@update');
//Роут что направлет на форму создания новой компании(магазина).
Route::get('/company/create', ['as' => 'company-create', 'uses' => 'CompanyController@create']);
//Роут что направляет на страницу, где нужно внести дополнительную информацию по магазину (поле дополнительная информация)
Route::get('/company-done-create', ['as' => 'company-done-create', 'uses' => 'CompanyController@store']);
//Создание компании и запись данных в БД (таблица companies)/
Route::post('/company-done-create', ['as' => 'company-done-create', 'uses' => 'CompanyController@store']);
//Удаление компании (магазина) принимает id - магазина.
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
//Роут на сохранение созданного товара продавцом. (В кабинете продавца).
Route::any('/products-category', ['as' => 'products-category', 'uses' => 'ProductsController@storeCategory']);
Route::get('/get-product-paginate', ['as' => 'get-product-paginate', 'uses' => 'ProductsController@productPaginate']);
//При нажатии на свой магазин в кабинете продавца. Просмотр свого магазина.Список товаров, категорий и статистика.
Route::get('/product-editor/{id}/{user_new?}', ['as'=>'product-editor','uses'=>'ProductsController@productEditor']);
//При нажатии на кнопку редактировать в кабинете продавца. Для вызова модального окна и начала редактирования.
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
/*-------------------------------------------Category----------------------------------------------*/
//Роут что переводит на страницу где можно добавить необходимые категории себе в магазин (продавцом), принимает id-магазина.
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
//Переход в корзину.
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
    //Страница где отображается список статусов продуктов по продуктам.
    Route::get('/status-product', ['as' => 'admin', 'uses'=>'AdminController@getStatusProduct']);
    //Роут для сохранения отредактированной информации по статусу товара.
    Route::post('/status-product-update', ['as' => 'admin', 'uses'=>'AdminController@statusProductUpdate']);
    //Создание нового статуса по продуктам.
    Route::post('/status-product-create', ['as' => 'admin', 'uses'=>'AdminController@statusProductCreate']);
    //Удаление статуса по продукту.
    Route::get('/status-product-delete/{id}', ['as' => 'admin', 'uses'=>'AdminController@statusProductDelete']);
    //Список всех товаров всех магазинов.
    Route::get('/product-list', ['as' => 'admin', 'uses'=>'AdminController@listProduct']);

});

/*-------------------------------------------Home--------------------------------------------*/
//Роут что направляет на страниц просмотра профиля пользователя другим пользователем.
Route::get('/show-user/{id}', 'UserController@getUserPage');

Route::get('/login-user', ['as' => 'login-user', 'uses' => 'HomeController@Index' ]);

//Ргистрация покупателя в ручном режиме продавцом.
Route::post('/register-handle', ['as' => 'register-handle', 'uses' => 'Auth\AuthController@createUserHandle' ]);

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
//Просмотр заказа (принимает id-заказа).
Route::get('/show-order/{id}', 'OrderController@showOrder');
//РОут на изменение статуса заказа продавцом (принимает id-заказа и id-нового статуса).
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
/*--------------------------------------------Groups-------------------------------------------*/
//Список групп пользователя
Route::get('/show-group-list', ['as'=>'show-group-list', 'uses'=>'GroupController@showGroupList']);
//Роут на создание группы. Происходит запись в таблицу groups.
Route::post('/group-create', ['as'=>'group-create', 'uses'=>'GroupController@createGroup']);
//Переход на страницу группы (где находится информация по группе) принимает id-группы.
Route::get('/single-group/{id}', 'GroupController@showSingleGroup');
//Отправление приглашения пользователю на вступление в группу.
Route::post('/group/send-invite', ['as'=>'group_invite_action', 'uses'=>'GroupController@ajaxInviteToGroup']);
//Отказатся от приглашения на вступление в группу (принимает id-группы).
Route::get('/disable-invite/{id}', ['as'=>'disable_group_invite', 'uses'=>'GroupController@disableInvite']);
//Принять приглашение на вступление в группу (принимает id-группы).
Route::get('/enable-invite/{id}', ['as'=>'enable_group_invite', 'uses'=>'GroupController@enableInvite']);
//Роут на удаление группы (удалить группу может только создатель группы) принимает id-группы.
Route::post('/group-destroy/{id}', ['as'=>'group-destroy', 'uses'=>'GroupController@destroy']);
//Роут для того что бы покинуть группу (покинуть может учасник группы, который вней состоит) принимает id-группы.
Route::post('/group-left/{id}', ['as'=>'group-left', 'uses'=>'GroupController@left']);
//Расширеный поиск пользователей в группе, для возможности пригласить в группу новых пользователей.
Route::post('/user/advanced_ajax_search', ['as'=>'advanced_ajax_search', 'uses'=>'UserController@ajaxAdvancedSearch']);
/*---------------------------------------------feedback------------------------------------------------------------------*/
//Роут чот перевоит на страницу оформления отзыва (принимает id-заказа).
Route::get('/feedback-view/{id}', ['as'=>'feedback-view', 'uses'=>'FeedbackController@start']);
//РОут создания отзыва (принимает id-заказа).
Route::post('/feedback-view/{id}', ['as'=>'feedback-view', 'uses'=>'FeedbackController@startSetup']);
//Просмотр своего отзыва (который был оставлен ранее) принимает id-продукта, id-заказаid.
Route::get('/show-my-feed/{product_id}/{order_id}/{user_id}', ['as'=>'show-my-feed', 'uses'=>'FeedbackController@showMyFeed']);
//Редактирование собственного отзыва.
Route::post('/add-ajax-change-feed', ['as'=>'add-ajax-change-feed', 'uses'=>'FeedbackController@editFeed']);
//Добавление дополнения к собственному отзыву.
Route::post('/add-ajax-addition-feed', ['as'=>'add-ajax-addition-feed', 'uses'=>'FeedbackController@additionFeed']);

/*-----------------------------------------------------------chat------------------------------------------------------------*/
Route::get('/get-single-conversation/{id_from}/{id_to}', ['as'=>'get-single-conversation', 'uses'=>'HomeController@getUserPageWithConversationUsers']);

Route::group(['middleware' => 'cors'], function(){
    Route::get('/who-am-i/{id}', ['as'=>'who_am_i', 'uses'=>'IndexController@whoAmI']);
    Route::post('/save-chat', ['as'=>'save_chat', 'uses'=>'IndexController@saveChat']);
    Route::get('/chat-history/{conversation}/{page}', ['as'=>'chat_history', 'uses'=>'IndexController@chatHistory']);
});









