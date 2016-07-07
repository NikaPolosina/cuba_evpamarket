<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use App\UserInformation;
use App\Company;

class AdminController extends Controller{
    public function index(){
        return view('admin.index');
    }

    public function allUser(){


        $user = UserInformation::all();
       /* $user = User::all();*/

        return view('admin.user.show')->with('user', $user);
    }

    public function userMan(){
        $user = UserInformation::where('gender', '=', 1)->get();
        return view('admin.user.show')->with('user', $user);
    }

    public function userWomen(){
        $user = UserInformation::where('gender', '=', 0)->get();
        return view('admin.user.show')->with('user', $user);
    }

    public function userBlocked(){
        die('Surprise, you are here !!!');
        $user = UserInformation::where('blocked', '=', 1)->get();
        return view('admin.user.show')->with('user', $user);
    }
    public function shopAll(){
        $shop = Company::all();
        return view('admin.company.show')->with('shop', $shop);
    }
    public function shopBlocked(){
        die('Surprise, you are here !!!');

        $shop = Company::all();
        return view('admin.company.show')->with('shop', $shop);
    }
}