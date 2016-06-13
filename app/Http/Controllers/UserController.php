<?php

namespace App\Http\Controllers;

use App\Http\Requests;
//use Faker\Provider\pl_PL\Company;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\UserCompany;
use App\User;
use App\Company;
use App\Region;
use App\City;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\UserInformation;

class UserController extends Controller{
    public function __construct(){
        $this->middleware('auth');
        $menu = array(
            'my_page'       => array(
                'title' => 'Моя страница',
                'url'   => '/home'
            ),
            'message'   => array(
                'title' => 'Центр сообщений',
                'url'   => '/user/simple_user/message'
            ),
            'payments' => array(
                'title' => 'Платежи',
                'url'   => '/user/simple_user/payments'
            ),
            'delivery'         => array(
                'title' => 'Доставка',
                'url'   => '/user/simple_user/delivery'
            ),
            'liked'         => array(
                'title' => 'Избранное',
                'url'   => '/user/simple_user/liked'
            ),
            'basket'         => array(
                'title' => 'Корзина',
                'url'   => '/user/simple_user/basket'
            ),
            'setting'         => array(
                'title' => 'Настройка',
                'url'   => '/user/simple_user/setting'
            )
        );
        view()->share('simple_user_menu', $menu);
    }

    public function home(){
        if(Auth::check()){
            $curentUser = Auth::user();
            $userInfo = $curentUser->getUserInformation;
        }

        return view('user.simple_user.home')->with('userInfo', $userInfo)->with('curentUser', $curentUser);

    }

    public function message(){

        return view('user.simple_user.message');
    }
    public function payments(){
        return view('user.simple_user.payments');
    }
    public function delivery(){
        return view('user.simple_user.delivery');
    }
    public function liked(){
        return view('user.simple_user.liked');
    }
    public function basket(){
        return view('user.simple_user.basket');
    }
    public function setting(){
        if(Auth::check()){
            $curentUser = Auth::user();
            $userInfo = $curentUser->getUserInformation;
        }
        $menu_setting = array(
            'overall'       => array(
                'title' => 'Общие настройки',
                'url'   => '/user/simple_user/setting/overall'
            ),
            'security'   => array(
                'title' => 'Безопасность',
                'url'   => '/user/simple_user/setting/security'
            )
        );
        return view('user.simple_user.setting')->with('menu_setting', $menu_setting)->with('userInfo', $userInfo);

    }
    public function settingOverall(Request $request){
        $curentUser = Auth::user();
        $info = $curentUser->getUserInformation;

        return view('user.simple_user.setting.settingOverall')->with('userInfo', $info);
    }
    public function settingSecurity(){

        return view('user.simple_user.setting.settingSecurity');
    }
    public function settingOverallEdit(Request $request){
        $curentUser = Auth::user();
        dd($request->all());

        $info = $curentUser->getUserInformation;
        $info->name = $request['name'];
        $info->surname = $request['surname'];
        $info->street = $request['street'];
        $info->address = $request['address'];
        $info->save();

    }


}
