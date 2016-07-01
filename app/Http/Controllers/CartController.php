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

    public function __construct(Request $request){
        view()->share('product_cnt', count($request->cookie('cart')));
    }

    public function index(Request $request){
        $product = '';

        if($request->cookie('cart')){
            $product = Product::whereIn('id', $request->cookie('cart'))->get();
            $product = IndexController::showProduct($product);
        }


        return view('product.products.cart')->with('product', $product);
    }

    public function destroy(Request $request){
        $id = $request['id'];
        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
            unset($cart[  array_search($request['id'], $cart) ] );
            return response()->json(['success'=>true,  'product_cnt'=> count(array_unique($cart)) ])->withCookie('cart', $cart);
        }
        return response()->json(['success'=>true]);
    }


}
?>