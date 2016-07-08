<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\User;
use App\UserInformation;
use App\Company;

class AdminController extends Controller{
    public function index(){
        return view('admin.home');
    }

    public function allUser(){
        $user = User::all();
        return view('admin.user.show')->with('user', $user);
    }

    public function userMan(User $user){
        $user = User::whereIn('id', UserInformation::where('gender', '1')->lists('user_id'))->get();
        return view('admin.user.show')->with('user', $user);
    }

    public function userWomen(){
        $user = User::whereIn('id', UserInformation::where('gender', '0')->lists('user_id'))->get();
        return view('admin.user.show')->with('user', $user);
    }

    public function userBlocked(){
        $user = User::where('block', 1)->get();
        return view('admin.user.show')->with('user', $user);
    }
    public function shopAll(){
        $shop = Company::all();
        return view('admin.company.show')->with('shop', $shop);
    }
    public function shopBlocked(){
        $shop = Company::where('block', 1)->get();
        return view('admin.company.show')->with('shop', $shop);
    }
    public function category(){
        $category = Category::all();
        return view('admin.category.show')->with('category', $category);
    }
}