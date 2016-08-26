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

class HomeController extends Controller{

    protected $_msg;

    public function __construct(MessageController $messageController){
        $this->middleware('auth');
        $this->_msg = $messageController;
    }

    public function Index(){

        /*Cookie::queue(
            Cookie::forget('cart')
        );*/

        if(Auth::user()->hasRole('admin')){
            return redirect()->intended('admin');
        }
        if(Auth::user()->hasRole('company_owner')){

            return redirect()->intended('homeOwnerUser');
        }
        if(Auth::user()->hasRole('simple_user')){

            return redirect()->intended('homeSimpleUser');
        }
    }

    public function registerSimple(){
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
        }

        return view('user.simple_user.home')->with('userInfo', $userInfo)->with('order', $order)->with('user', $curentUser)->with('groupInvites', $groupInvites);
    }

    public function registerOwner(CompanyController $companyController){
        if(Auth::check()){
            $curentUser = Auth::user();
            foreach($curentUser->getCompanies as $value){
                $value->company_logo = $companyController->showCompanyLogo($value->id);
            }
            $userInfo = $curentUser->getUserInformation;
        }
        return view('homeOwnerUser')->with('userInfo', $userInfo)->with('curentUser', $curentUser);
    }

    public function test(){
        return view('test');
    }
}
