<?php
namespace App\Http\Controllers;

use App\Http\Requests;
//use Faker\Provider\pl_PL\Company;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\UserCompany;
use App\User;
use App\Company;
use App\Region;
use App\City;
use App\Http\Controllers\CategoryController;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\UserInformation;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Cookie;
use Creitive\Breadcrumbs\Breadcrumbs;
class HomeController extends Controller{
    protected $_msg;
    protected $_companyController;
    protected $_breadcrumbs;

    public function __construct(MessageController $messageController, CompanyController $companyController, Breadcrumbs $breadcrumbs){
        $this->middleware('auth');
        $this->_msg = $messageController;
        $this->_companyController = $companyController;
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider('<img style="display: inline-block;  height: 37px;" src="/img/system/next-bread.png">');
    }

    public function Index(Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs->addCrumb('Домой', '/login-user');

        /*Cookie::queue(
            Cookie::forget('cart')
        );*/
        if(Auth::user()->hasRole('admin')){
            return redirect()->intended('admin');
        }
        if(Auth::user()->hasRole('company_owner')){
            return redirect()->intended('homeOwnerUser')->with('breadcrumbs', $this->_breadcrumbs);
        }
        if(Auth::user()->hasRole('simple_user')){
            return redirect()->intended('homeSimpleUser')->with('breadcrumbs', $this->_breadcrumbs);
        }
    }


    public function getUserPageWithConversationUsers($from_id, $to_id, MessageController $mesage){
        $data = $this->prepeareHomeInfo($mesage);
        $betvin = $mesage->getChatBetweenTwoUser($from_id, $to_id);
        $data['userInfo']['beetwenTwo'] = $betvin;

       //dd($data['userInfo']['beetwenTwo']);

        return view('user.simple_user.home')
            ->with('userInfo', $data['userInfo'])
            ->with('order', $data['order'])
            ->with('user', $data['user'])
            ->with('groupInvites', $data['groupInvites'])
            ->with('product', $data['product'])
            ->with('breadcrumbs', $this->_breadcrumbs);

    }

    public function prepeareHomeInfo($mesage){

        if(!Auth::user()->getUserInformation){
            $region = Region::all();
            return view('auth.register_aditional')->with('region', $region);
        }
        if(Auth::check()){
            $curentUser = Auth::user();
            $userInfo = $curentUser->getUserInformation;
            $companies = $curentUser->getCompanies;
            $order = Order::where('simple_user_id', '=', Auth::user()->id)->get();
            $this->_msg->getGroupInvite(Auth::user(), [ 'status' => 0 ]);
            $groupInvites = $this->_msg->getMsg()->count();
            $userInfo['msgAll'] = $mesage->getAllUserWhoSendMsg(Auth::user()->id);
        }

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $product = [];
        $curentUser = Auth::user();
        $product = $curentUser->getProduct;
        $product = IndexController::showProduct($product);

        $data['userInfo'] = $userInfo;
        $data['order'] = $order;
        $data['user'] = $curentUser;
        $data['groupInvites'] = $groupInvites;
        $data['product'] = $product;

        return $data;

    }


    public function registerSimple(MessageController $mesage){

        $data = $this->prepeareHomeInfo($mesage);

        return view('user.simple_user.home')
            ->with('userInfo', $data['userInfo'])
            ->with('order', $data['order'])
            ->with('user', $data['user'])
            ->with('groupInvites', $data['groupInvites'])
            ->with('product', $data['product'])
            ->with('breadcrumbs', $this->_breadcrumbs);
    }

    public function registerOwner(){
        if(Auth::check()){
            $curentUser = Auth::user();
            foreach($curentUser->getCompanies as $value){
                $value->company_logo = $this->_companyController->showCompanyLogo($value->id);
            }
            $userInfo = $curentUser->getUserInformation;
            $this->_msg->getGroupInvite(Auth::user(), [ 'status' => 0 ]);
            $groupInvites = $this->_msg->getMsg()->count();
        }
        $this->_breadcrumbs->addCrumb('Домой', '/login-user');

        return view('homeOwnerUser')
            ->with('userInfo', $userInfo)
            ->with('curentUser', $curentUser)
            ->with('groupInvites', $groupInvites)
            ->with('breadcrumbs', $this->_breadcrumbs);
    }

    public function test(){
        return view('test');
    }
}
