<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;


class CartController extends Controller{

    public function index(Request $request){
        if($request->cookie('cart')){
            $cart = $request->cookie('cart');

            foreach($cart as $val){
                $product = Product::find($val)->get();
                $a = IndexController::showProduct($product);
            }
        }



        return view('product.products.cart')->with('product', $a);
    }


}
?>