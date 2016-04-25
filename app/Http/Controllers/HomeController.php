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
use App\Models\Permission;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
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
    public function index(User $user, UserCompany $userCompany, Company $company,  $id = null)
    {

        //$name = 'mhY';

/*        $i = 0;

        do{

            $product_description = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
            $product_image = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $product_id = substr(str_shuffle("1234567890"), 0, 3);
            $product_price = substr(str_shuffle("1234567890"), 0, 5);
            $newProduct = new Product([
                'product_id'          => $product_id,
                'product_description' => $product_description,
                'product_image'       => $product_image,
                'product_price'       => $product_price,
            ]);
            $newProduct->save();
            $i++;
        }while($i <= 100000);*/



        if(Auth::check()){
            $curentUser = Auth::user();
            $companies = $curentUser->getCompanies;
        }
        return view('home')->with('curentUser', $curentUser);

    }
}
