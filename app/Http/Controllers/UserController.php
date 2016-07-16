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
use Redirect;
use File;

class UserController extends Controller{
    public function __construct(){
        $this->middleware('auth');
        $menu = array(
            'my_page'  => array(
                'title' => 'Моя страница',
                'url'   => '/home',
                'span'  => 'glyphicon glyphicon-user'
            ),
            'message'  => array(
                'title' => 'Центр сообщений',
                'url'   => '/user/simple_user/message',
                'span'  => 'glyphicon glyphicon-envelope'
            ),
            'payments' => array(
                'title' => 'Платежи',
                'url'   => '/user/simple_user/payments',
                'span'  => 'glyphicon glyphicon-usd'
            ),
            'delivery' => array(
                'title' => 'Доставка',
                'url'   => '/user/simple_user/delivery',
                'span'  => 'glyphicon glyphicon-send'
            ),
            'liked'    => array(
                'title' => 'Избранное',
                'url'   => '/user/simple_user/liked',
                'span'  => 'glyphicon glyphicon-heart'
            ),
            'basket'   => array(
                'title' => 'Корзина',
                'url'   => '/user/simple_user/basket',
                'span'  => 'glyphicon glyphicon-trash'
            ),
            'setting'  => array(
                'title' => 'Настройка',
                'url'   => '/user/simple_user/setting',
                'span'  => 'glyphicon glyphicon-cog'
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
        return view('user.simple_user.setting')->with('userInfo', $userInfo)->with('user', $curentUser);
    }

    public function settingSecurity(){
        return view('user.simple_user.setting.settingSecurity');
    }

    public function settingOverallEdit(Request $request){
        $curentUser = Auth::user();
        $info = $curentUser->getUserInformation;
        $info->name = $request['name'];
        $info->surname = $request['surname'];
        $info->street = $request['street'];
        $info->address = $request['address'];
        $info->about_me = $request['about_me'];
        $info->my_site = $request['my_site'];
        $info->save();
        return redirect('/home');
    }

    public function createAvatar(Request $request){
        $curentUser = Auth::user();
        $name = 'avatar';
        $path = public_path().'/img/users/' . $curentUser->id;
        $width = 300;
        $height = 300;
        $file = $request['avatar'];
        File::makeDirectory($path, $mode = 0777, true, true);
        $path = public_path() . '/img/users/' . $curentUser->id;
        $file = $request['avatar'];
        $type = exif_imagetype($file);
        if($type == IMAGETYPE_JPEG){
            $image = imagecreatefromjpeg($file);
        }else if($type == IMAGETYPE_GIF){
            $image = imagecreatefromgif($file);
        }else if($type == IMAGETYPE_PNG){
            $image = imagecreatefrompng($file);
        }else{
            return false;
        }
        File::makeDirectory($path, $mode = 0777, true, true);
        imagepng($image, $path . '/' . $name . '.png');



        $info = $curentUser->getUserInformation;
        $info->avatar = '/img/users/' . $curentUser->id . '/' . $name . '.png';
        $info->save();


        FileController::cropFile($file,$path,$width,$height,$name);

        return redirect('/home');
    }


       /* return redirect('/login-user');*/




    public function setRole(Request $request, HomeController $homeController){
        $curentUser = Auth::user();

        if($request->input('role') == 'simple_user'){
            $curentUser->detachRoles($curentUser->roles);
            $curentUser->attachRole(Role::findOrFail(2));
            return $homeController->registerSimple();
        }

        if($request->input('role') == 'company_owner'){
            $curentUser->detachRoles($curentUser->roles);
            $curentUser->attachRole(Role::findOrFail(1));
            return $homeController->registerOwner();
        }

    }

}
