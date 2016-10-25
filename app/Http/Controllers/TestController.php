<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\StatusOwner;
use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use Mockery\Exception;
use Session;
use App\Company;
use Auth;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Validator;
use Creitive\Breadcrumbs\Breadcrumbs;
use App\AdditionParam;

class TestController extends Controller{
    public function myTest(){

        $addParam = AdditionParam::all();
        
        
        

        foreach($addParam as $item){
            $item->value = json_decode($item->value, true);
        }

        
        

        return view('product.additionParam')->with('addParam', $addParam->toArray());
    }
}