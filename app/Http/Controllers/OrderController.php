<?php

namespace App\Http\Controllers;
use App\Region;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller{
    public function createOrder(){
        if(!Auth::user()){
            die(' не залогинен!!!');
        }
        $user = Auth::user();
        $info_user =  $user->getUserInformation;
        $region = Region::find($info_user['region_id']);
        $city = City::find($info_user['city_id']);
        return view('order.create')
            ->with('user', $user)
            ->with('info_user', $info_user)
            ->with('region', $region)
            ->with('city', $city);
    }
    public function ready(Request $request){
        dd($request->all());
        return view('order.ready');
    }
}