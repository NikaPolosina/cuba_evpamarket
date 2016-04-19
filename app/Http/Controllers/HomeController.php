<?php

namespace App\Http\Controllers;

use App\Http\Requests;
//use Faker\Provider\pl_PL\Company;
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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, UserCompany $userCompany, Company $company,  $id = null)
    {

        if(Auth::user()){
            $curentUser = Auth::user();

            $results = DB::select('select * from companies where id = ?', [7]);

dd($results);

        }

        return view('home')->with('curentUser', $curentUser);

    }
}
