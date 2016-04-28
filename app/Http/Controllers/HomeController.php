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

class HomeController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, UserCompany $userCompany, Company $company, $id = NULL){

        if(!Auth::user()->getUserInformation){
            $region = Region::all();
//            $city = City::all();
            return view('auth.register_aditional')->with('region', $region);

        }


        if(Auth::check()){
            $curentUser = Auth::user();
            $userInfo = $curentUser->getUserInformation;
            $companies = $curentUser->getCompanies;
        }
        if(Auth::user()->hasRole('company_owner')){
            return view('home')->with('userInfo', $userInfo)->with('curentUser', $curentUser);
        }


        return view('homeSimpleUser')->with('userInfo', $userInfo)->with('curentUser', $curentUser);

    }
}
