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
    }
    /**
     * Show cart
     * */
    public function index(Request $request){

        $product = '';
        $companies = array();

        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
        }

        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';

        $cart[$k] =  (isset($cart[$k])) ? $cart[$k] : array();

        if($cart[$k]){
            foreach($cart[$k] as $key => $company){
                $companies[$key]['company'] = Company::find($key);
                $companies[$key]['products'] = $companies[$key]['company']->getProducts()->whereIn('id', array_keys($company['products']))->get();

                $companies[$key]['products'] = IndexController::showProduct($companies[$key]['products']);

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


    public function cart(Request $request){

        $cnt = 0;


        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
        }
        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
        $cart[$k] =  (isset($cart[$k])) ? $cart[$k] : array();

        $currentCompany = Product::find($request->input('id'))->getCompany()->first();
        $currentCompanyId = $currentCompany->id;

        if(array_key_exists($currentCompanyId,  $cart[$k])){
            if(array_key_exists($request->input('id'),  $cart[$k][$currentCompanyId]['products'])){
                 $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt']++;
            }else{
                 $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'] = 1;
            }
        }else{
             $cart[$k][$currentCompanyId] = array();
             $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'] = 1;
        }

        foreach( $cart[$k] as $company){
            foreach($company['products'] as $product){
                $cnt += $product['cnt'];
            }
        } 

        $total = 0;
        foreach( $cart[$k][$currentCompanyId]['products'] as $key => $product){
            $total += Product::find($key)->product_price * $product['cnt'];
        }

        return response()->json([
            'success'       => true,
            'product_cnt'   => $cnt,
            'product'       => Product::find($request->input('id')),
            'total_in_shop' => $total
        ], 200)->withCookie(cookie('cart', $cart));
    }


    public function destroy(Request $request){
        $id = $request['id'];
        $cart = array();
        $cnt = 0;

        if($request->cookie('cart')){
//            $cart = $request->cookie('cart');

            if($request->cookie('cart')){
                $cart = $request->cookie('cart');
            }

            $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';

            $cart[$k] =  (isset($cart[$k])) ? $cart[$k] : array();
            

            $currentCompany = Product::find($request->input('id'))->getCompany()->first();
            $currentCompanyId = $currentCompany->id;

            $cn = 0;
            if(array_key_exists($currentCompanyId, $cart[$k])){
                $cn = $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'];
                unset($cart[$k][$currentCompanyId]['products'][$request->input('id')]);
                $current_company_cnt = count($cart[$k][$currentCompanyId]['products']);
                if(!$current_company_cnt)
                    unset($cart[$k][$currentCompanyId]);
            }

            foreach($cart[$k] as $company){
                foreach($company['products'] as $product){
                    $cnt += $product['cnt'];
                }
            }

            $total = CartController::getProductCount($request)-$cn;

            return response()->json([
                'success'       => true,
                'product_cnt'   => $cnt,    
                'product'       => Product::find($request->input('id')),
                'total_in_shop' => $total,
                'in_current_company' =>$current_company_cnt
            ], 200)->withCookie(cookie('cart', $cart));

            
        }
        return response()->json([ 'success' => true ]);
    }


    public function cartAddCnt(Request $request){

        $cnt = 0;

        $cart = array();

        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
        }

        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
        $cart[$k] =  (isset($cart[$k])) ? $cart[$k] : array();

        $currentCompany = Product::find($request->input('id'))->getCompany()->first();
        $currentCompanyId = $currentCompany->id;

        if(array_key_exists($currentCompanyId, $cart[$k])){
            if(array_key_exists($request->input('id'), $cart[$k][$currentCompanyId]['products'])){
                $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'] = $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'] + $request->input('cnt') - 1;
            }
        }

        foreach($cart[$k] as $company){
            foreach($company['products'] as $product){
                $cnt += $product['cnt'];
            }
        }


        $total = 0;
        foreach($cart[$k][$currentCompanyId]['products'] as $key => $product){
            $total += Product::find($key)->product_price * $product['cnt'];
        }
        
        return response()->json([
            'success'       => true,
            'product_cnt'   => $cnt,
            'product'       => Product::find($request->input('id')),
            'total_in_shop' => $total
        ], 200)->withCookie(cookie('cart', $cart));
    }

    /**
     * Get product count
     * */
    public static function getProductCount(Request $request){
        $cnt = 0;

        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
        $cart = $request->cookie('cart');

        if($request->cookie('cart')){
            $cart[$k] =  (isset($cart[$k])) ? $cart[$k] : array();
            foreach($cart[$k] as $company){
                foreach($company['products'] as $product){
                    $cnt += $product['cnt'];
                }
            }
        }

        return $cnt;
    }
}

?>