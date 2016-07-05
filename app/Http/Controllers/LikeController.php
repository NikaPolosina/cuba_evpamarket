<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;


class LikeController extends Controller{

    public function __construct(Request $request){

    }

    public function index(Request $request){
        $product = '';

        $curentUser = User::find(108);
        dd($curentUser->getProduct);
        $product = $curentUser->getProduct;


        $product = IndexController::showProduct($product);

        return view('product.products.like')->with('product', $product);
    }



}
?>