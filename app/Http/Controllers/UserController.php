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
                'url'   => '/home',
                'span' => 'glyphicon glyphicon-user'
            ),
            'message'   => array(
                'title' => 'Центр сообщений',
                'url'   => '/user/simple_user/message',
                'span' => 'glyphicon glyphicon-envelope'
            ),
            'payments' => array(
                'title' => 'Платежи',
                'url'   => '/user/simple_user/payments',
                 'span' => 'glyphicon glyphicon-usd'
            ),
            'delivery'         => array(
                'title' => 'Доставка',
                'url'   => '/user/simple_user/delivery',
                'span' => 'glyphicon glyphicon-send'
            ),
            'liked'         => array(
                'title' => 'Избранное',
                'url'   => '/user/simple_user/liked',
                'span' => 'glyphicon glyphicon-heart'
            ),
            'basket'         => array(
                'title' => 'Корзина',
                'url'   => '/user/simple_user/basket',
                'span' => 'glyphicon glyphicon-trash'
            ),
            'setting'         => array(
                'title' => 'Настройка',
                'url'   => '/user/simple_user/setting',
                'span' => 'glyphicon glyphicon-cog'
            )
        );
        view()->share('simple_user_menu', $menu);
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

        return view('user.simple_user.setting')->with('userInfo', $userInfo)->with('user',$curentUser );

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
