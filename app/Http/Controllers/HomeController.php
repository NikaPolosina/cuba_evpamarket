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
use App\Http\Controllers\CategoryController;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\UserInformation;
use App\Http\Controllers\FileController;

class HomeController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function Index(){
        if(Auth::user()->hasRole('admin')){
            return redirect()->intended('admin');
        }
        if(Auth::user()->hasRole('company_owner')){
            return redirect()->intended('homeOwnerUser');
        }
        if(Auth::user()->hasRole('simple_user')){
            return redirect()->intended('home');
        }
    }

    public function registerSimple(User $user, UserCompany $userCompany, Company $company, FileController $file, Request $request, $id = NULL){
        if(!Auth::user()->getUserInformation){
            $region = Region::all();
            return view('auth.register_aditional')->with('region', $region);
        }
        if(Auth::check()){
            $curentUser = Auth::user();
            $userInfo = $curentUser->getUserInformation;
            $companies = $curentUser->getCompanies;
        }
        if(Auth::user()->hasRole('company_owner')){
            $curentUser->detachRoles($curentUser->roles);
            $curentUser->attachRole(Role::findOrFail(2));
        }
        return view('user.simple_user.home')->with('userInfo', $userInfo)->with('user', $curentUser);
    }

    public function registerOwner(User $user, UserCompany $userCompany, Company $company, $id = NULL){
        if(Auth::check()){
            $curentUser = Auth::user();
            $userInfo = $curentUser->getUserInformation;
            $companies = $curentUser->getCompanies;
            if($curentUser->hasRole('simple_user')){
                $curentUser->detachRoles($curentUser->roles);
                $curentUser->attachRole(Role::findOrFail(1));
            }
        }
        return view('homeOwnerUser')->with('userInfo', $userInfo)->with('curentUser', $curentUser);
    }

    public function test(){
        return view('test');
    }
}
