<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\User;
use App\UserInformation;


class AdminController extends Controller{
        public function index(){
            return view('admin.index');

        }
        public function allUser(){
            $user = UserInformation::all();
                return view('admin.user')->with('user', $user);
            }
        public function userMan(){
            $user = UserInformation::where('gender', '=', 1)->get();
                return view('admin.user')->with('user', $user);
            }
        public function userWomen(){
            $user = UserInformation::where('gender', '=', 0)->get();
                return view('admin.user')->with('user', $user);
            }
        public function userBlocked(){
            die('Surprise, you are here !!!');

            $user = UserInformation::where('blocked', '=', 1)->get();
                return view('admin.user')->with('user', $user);
            }
}