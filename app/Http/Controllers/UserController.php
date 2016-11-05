<?php
namespace App\Http\Controllers;

use App\Http\Requests;
//use Faker\Provider\pl_PL\Company;
use App\Product;
use Carbon\Carbon;
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
use Validator;
use Creitive\Breadcrumbs\Breadcrumbs;

class UserController extends Controller{

    protected $_user;
    protected $_userModel;
    protected $_request;
    protected $_breadcrumbs;

    public function __construct(User $user, Request $request, Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider('<img style="display: inline-block;  height: 37px;" src="/img/system/next-bread.png">');


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

        $this->_userModel = $user;
        $this->_request = $request;
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

    public function settingOverallEditSimple(Request $request){

        $v = Validator::make($request->all(), [
            'name'    => 'required|min:2',
            'surname' => 'required|min:3',
        ]);

        if($v->fails()){
            return redirect()->back()->withErrors($v->errors());
        }

        $curentUser = Auth::user();
        $info = $curentUser->getUserInformation;
        $info->name = $request['name'];
        $info->surname = $request['surname'];
        $curentUser->email = $request['email'];
        $info->street = $request['street'];
        $info->address = $request['address'];

        $info->save();
        $curentUser->save();
        return redirect('/login-user');
    }

    public function settingOverallEditOwner(Request $request){
        $curentUser = Auth::user();
        $info = $curentUser->getUserInformation;
        $info->name = $request['name'];
        $info->surname = $request['surname'];
        $curentUser->email = $request['email'];
        $curentUser->phone = $request['phone'];
        $info->street = $request['street'];
        $info->address = $request['address'];
        $info->about_me = $request['about_me'];
        $info->my_site = $request['my_site'];
        $info->street = $request['street'];
        $info->address = $request['address'];
        $info->save();

        $curentUser->save();

        return redirect('/login-user');
    }

    public function createAvatar(Request $request){

        $curentUser = Auth::user();
        $name = 'avatar';
        $path = public_path().'/img/users/'.$curentUser->id;
        $width = 300;
        $height = 300;

        File::makeDirectory($path, $mode = 0777, true, true);
        $path = public_path().'/img/users/'.$curentUser->id;
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
        imagepng($image, $path.'/'.$name.'.png');

        $info = $curentUser->getUserInformation;
        $info->avatar = '/img/users/'.$curentUser->id.'/'.$name.'.png';
        $info->save();

        FileController::cropFile($file, $path, $width, $height, $name);

        return redirect('/login-user');
    }

    /* return redirect('/login-user');*/

    public function setRole(Request $request, HomeController $homeController,MessageController $mesage){
        $curentUser = Auth::user();

        if($request->input('role') == 'simple_user'){
            $curentUser->detachRoles($curentUser->roles);
            $curentUser->attachRole(Role::where('name', 'simple_user')->first());
            return $homeController->registerSimple($mesage);
        }
        if($request->input('role') == 'company_owner'){
            $curentUser->detachRoles($curentUser->roles);
            $curentUser->attachRole(Role::where('name', 'company_owner')->first());
            return $homeController->registerOwner($mesage);
        }
    }

    /**
     * Check if item exists
     * */
    public function checkExists($id){
        $this->_request->request->add([ 'item' => $id ]);
        $this->validate($this->_request, [
            'item' => 'required|exists:users,id'
        ]);
    }

    /**
     * Get current group
     *
     * @return User
     */
    public function getUser(){
        return $this->_user;
    }

    /**
     *
     * Set current user
     */
    public function setUser(User $user){
        $this->_user = $user;
    }

    /**
     * Get group model
     * */
    public function getModel(){
        return new $this->_userModel;
    }

    /**
     * Advanced user search by params
     * */
    public function ajaxAdvancedSearch(GroupController $group){
        try{
            $this->_user = $this->_advancedSearch($this->_request->params);
            // todo: avatar prepare
            $this->_user = $group->prepareUserAvatar($this->_user);

            return response()->json([ 'data' => $this->_user ], 200);
        }catch(\Exception $e){
            return response()->json([ 'error' => $e->getMessage() ], 422);
        }
    }

    /**
     * Advanced search
     *
     * @param array $params
     *
     * @return object
     * */
    protected function _advancedSearch(array $params){
        $params = $this->_prepareAdvancedSearch($params);

        $query = User::select([ 'users.*' ])->join('user_informations', 'users.id', '=', 'user_informations.user_id');

        //dd($params);
        if(isset($params['name'])){
            $query->where('user_informations.name', $params['name']);
        }

        if(isset($params['surname'])){
            $query->where('user_informations.surname', $params['surname']);
        }

        if(isset($params['age_from'])){
            $query->where('user_informations.date_birth', '<=', $params['age_from']);
        }

        if(isset($params['age_to'])){
            $query->where('user_informations.date_birth', '>=', $params['age_to']);
        }

        if(isset($params['gender'])){
            $query->where('user_informations.gender', $params['gender']);
        }

        if(isset($params['region'])){
            $query->where('user_informations.region_id', $params['region']);
        }

        if(isset($params['city'])){
            $query->where('user_informations.city_id', $params['city']);
        }

        if(!$query->count()){

            $query = User::select([ 'users.*' ])->join('user_informations', 'users.id', '=', 'user_informations.user_id');

            if(isset($params['name'])){
                $query->where('user_informations.name', 'LIKE', '%'.$params['name'].'%');
            }

            if(isset($params['surname'])){
                $query->orWhere('user_informations.surname', 'LIKE', '%'.$params['surname'].'%');
            }

            if(isset($params['age_from'])){
                $query->where('user_informations.date_birth', '<=', $params['age_from']);
            }

            if(isset($params['age_to'])){
                $query->where('user_informations.date_birth', '>=', $params['age_to']);
            }

            if(isset($params['gender'])){
                $query->where('user_informations.gender', $params['gender']);
            }

            if(isset($params['region'])){
                $query->where('user_informations.region_id', $params['region']);
            }

            if(isset($params['city'])){
                $query->where('user_informations.city_id', $params['city']);
            }

            $query->orderBy('user_informations.name');
        }

        return $query->get();
    }

    /**
     * Prepare advanced search param
     *
     * @param array $params
     *
     * @return array
     * */
    protected function _prepareAdvancedSearch(array $params){

        if(!$params['name']){
            unset($params['name']);
        }

        if(!$params['surname']){
            unset($params['surname']);
        }

        if(!$params['age_from']){
            unset($params['age_from']);
        }else{
            $params['age_from'] = Carbon::createFromDate(Carbon::today()->format('Y') - $params['age_from'], 1, 1);
        }

        if(!$params['age_to']){
            unset($params['age_to']);
        }else{
            $params['age_to'] = Carbon::createFromDate(Carbon::today()->format('Y') - $params['age_to'], 1, 1);
        }

        if($params['gender'] == 'men'){
            $params['gender'] = 1;
        }elseif($params['gender'] == 'women'){
            $params['gender'] = 0;
        }else{
            unset($params['gender']);
        }

        if(!$params['region']){
            unset($params['region']);
        }

        if(!$params['city']){
            unset($params['city']);
        }

        return $params;
    }


    public function getUserPage($id){
        $user = User::where('id', $id)->with('getUserInformation')->get();
        if(!count($user)){
          return redirect()->back();

        }



        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb($user[0]->getUserInformation->name.' '.$user[0]->getUserInformation->surname, '/show-user/'.$user[0]->id);

        
        return view('user.simple_page')
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('user', $user);
        
        
    }
}
