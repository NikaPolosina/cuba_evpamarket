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
        view()->share('product_cnt', self::getProductCount($request));
    }

    /**
     * Show cart
     * */
    public function index(Request $request){
        $product = '';
        $companies = array();
        if($request->cookie('cart')){
            foreach($request->cookie('cart') as $key => $company){
                $companies[$key]['company'] = Company::find($key);
                $companies[$key]['products'] = $companies[$key]['company']->getProducts()->whereIn('id', array_keys($company['products']))->get();

                foreach ($companies[$key]['products'] as $value) {

                    if(array_key_exists($value->id, $company['products'])){
                        $value->cnt = $company['products'][$value->id]['cnt'];
                    }else{
                        $value->cnt = 0;                         
                    }
                }
            }
        }
        return view('product.products.cart')->with('companies', $companies);
    }

    public function destroy(Request $request){
        $id = $request['id'];
        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
            unset($cart[array_search($request['id'], $cart)]);
            return response()->json([
                'success'     => true,
                'product_cnt' => count(array_unique($cart))
            ])->withCookie('cart', $cart);
        }
        return response()->json([ 'success' => true ]);
    }

    /**
     * Get product count
     * */
    public static function getProductCount(Request $request){
        $cnt = 0;
        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
            foreach($cart as $company){
                foreach($company['products'] as $product){
                    $cnt += $product['cnt'];
                }
            }
        }
        return $cnt;
    }
}

?>