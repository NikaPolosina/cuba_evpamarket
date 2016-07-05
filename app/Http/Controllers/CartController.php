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
        $cart = array();
        $cnt = 0;

        if($request->cookie('cart')){
            $cart = $request->cookie('cart');

            $currentCompany = Product::find($request->input('id'))->getCompany()->first();
            $currentCompanyId = $currentCompany->id;

            if(array_key_exists($currentCompanyId, $cart)){
                unset($cart[$currentCompanyId]['products'][$request->input('id')]);
            }

            foreach($cart as $company){
                foreach($company['products'] as $product){
                    $cnt += $product['cnt'];
                }
            }

            $total = CartController::getProductCount($request);

            return response()->json([
                'success'       => true,
                'product_cnt'   => $cnt,
                'product'       => Product::find($request->input('id')),
                'total_in_shop' => $total
            ], 200)->withCookie(cookie('cart', $cart));

            
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