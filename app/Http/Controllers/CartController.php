<?php

namespace App\Http\Controllers;

use App\Category;
use App\DiscountAccumulativ;
use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;
use App\StatusOwner;
use Creitive\Breadcrumbs\Breadcrumbs;
use App\AdditionParam;

class CartController extends Controller{

    protected $_cart = array();
    protected $_currentUserKey;
    protected $_totalCnt;
    protected $_totalAmount;
    protected $_breadcrumbs;

    /**
     * Initial setup
     * */
    public function __construct(Request $request, Breadcrumbs $breadcrumbs){

        $this->_cart = (($request->cookie('cart'))) ? $request->cookie('cart') : array();

        $this->_currentUserKey = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';

        if(!array_key_exists($this->_currentUserKey, $this->_cart)){
            $this->_cart[$this->_currentUserKey] = array();
        }
        $this->_totalCnt = 0;
        $this->_totalAmount = 0;
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider('<img style="display: inline-block;  height: 37px;" src="/img/system/next-bread.png">');
    }

    /**
     * Show cart
     * */
    //Метод отвечающий за переход в корзину пользователя.
    public function index(Request $request){


        $product = '';
        $companies = array();

        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
        }

        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';

        $cart[$k] = (isset($cart[$k])) ? $cart[$k] : array();

        if($cart[$k]){
            foreach($cart[$k] as $key => $company){
                $companies[$key]['company'] = Company::find($key);
                $companies[$key]['products'] = array();
                $companies[$key]['totalAmount'] = 0;

                if(count($company['products'])){
                    foreach ($company['products'] as $hash => $cartProduct) {
                        $product = $companies[$key]['company']->getProducts()->where('id', $cartProduct['product_id'])->with('getCategory')->first();

                        $product->cnt = $cartProduct['cnt'];

                        if(array_key_exists('add_param', $cartProduct)){
                            $cartProduct['add_param'] = json_decode($cartProduct['add_param'], true);
                            if(is_array($cartProduct['add_param']) && array_key_exists('current_price', $cartProduct['add_param'])){
                                $product->product_price = $cartProduct['add_param']['current_price'];
                            }
                            $product->value = $cartProduct['add_param']['add_param'];
                        }else{
                            $product->value = array();

                        }
                        $companies[$key]['totalAmount'] = $companies[$key]['totalAmount']+ ($product->product_price*$product->cnt);
                        $product->hash = $hash;
                        $companies[$key]['products'][] = $product;
                    }

                    $companies[$key]['products'] = IndexController::showProduct($companies[$key]['products']);

                    if(Auth::user()){
                        $companies[$key]['totalHistoryAmount'] = OrderController::getTotalCompanyAmount($companies[$key]['company'], StatusOwner::where('key','sending_buyer')->first(), Auth::user());

                        $companies[$key]['total'] = $companies[$key]['totalAmount'] + $companies[$key]['totalHistoryAmount'];

                        if(Auth::user()->getGroup()->where('company_id', $key)->count()){
                            $companies[$key]['totalHistoryAmount'] = Auth::user()->getGroup()->where('company_id', $key)->max('money');
                            $companies[$key]['total'] = $companies[$key]['totalAmount'] + $companies[$key]['totalHistoryAmount'];
                        }

                        $companies[$key]['discount'] = $companies[$key]['company']->getDiscountAccumulativ()->where('from', '<=', $companies[$key]['total'])->orderBy('from', 'desc')->first();
                    }
                }else{
                    unset($companies[$key]);
                }
            }

        }

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Корзина', '/cart');

        return view('product.cart')
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('companies', $companies);
    }

    public function cart(Request $request){

        $cnt = 0;

        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
        }
        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
        $cart[$k] = (isset($cart[$k])) ? $cart[$k] : array();

        $currentCompany = Product::find($request->input('id'))->getCompany()->first();
        $currentCompanyId = $currentCompany->id;

        if(array_key_exists($currentCompanyId, $cart[$k])){
            if(array_key_exists($request->input('id'), $cart[$k][$currentCompanyId]['products'])){
                $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt']++;
            }else{
                $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'] = 1;
            }
        }else{
            $cart[$k][$currentCompanyId] = array();
            $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'] = 1;
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

    public function destroy(Request $request){

        $hash = $request->hash;
        $currentCompanyId = $request->company;

        $cart = array();
        $cnt = 0;

        if($request->cookie('cart')){

            if($request->cookie('cart')){
                $cart = $request->cookie('cart');
            }
            $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
            $cart[$k] = (isset($cart[$k])) ? $cart[$k] : array();

            if(array_key_exists($currentCompanyId, $cart[$k])){
                unset($cart[$k][$currentCompanyId]['products'][$hash]);
            }

            return response()->json([
                'success'            => true
            ], 200)->withCookie(cookie('cart', $cart));
        }
    }

    public function cartAddCnt(Request $request){
    


        $cnt = 0;

        $cart = array();

        if($request->cookie('cart')){
            $cart = $request->cookie('cart');
        }

        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
        $cart[$k] = (isset($cart[$k])) ? $cart[$k] : array();

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
     * Return total cart product count
     * */
    public function getTotalProductCnt(){
        $this->_userCartProductCnt();
        return $this->_totalCnt;
    }

    /**
     * Add product to cart - ajax
     * */
    public function ajaxCart(Request $request){
        $this->validate($request, [
            'product_id' => 'required|integer',
            'cnt'        => 'required|integer',
        ]);

        try{
            $this->addToCart([ $request->all() ]);
            return response()->json([
                'total_count' => $this->getTotalProductCnt(),
            ], 200)->withCookie(cookie('cart', $this->_cart));
        }catch(\Exception $e){
            return response()->json([ 'error' => $e->getMessage() ], 422);
        }
    }

    /**
     * Add to cart
     *
     * @param array $products
     * */
    public function addToCart(array $products){

        foreach($products as $singleProduct){
            $currentCompanyId = Product::find($singleProduct['product_id'])->getCompany()->first()->id;
            if(!array_key_exists($currentCompanyId, $this->_cart[$this->_currentUserKey])){
                $this->_cart[$this->_currentUserKey][$currentCompanyId] = array();
            }
            $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'][substr( md5(rand()), 0, 7)] = $singleProduct;
        }
    }

    /**
     * Count all product of current user cart
     * */
    private function _userCartProductCnt(){
        $this->_totalCnt = 0;
        foreach($this->_cart[$this->_currentUserKey] as $singleCompany){
            foreach($singleCompany['products'] as $productCnt){
                $this->_totalCnt = $this->_totalCnt + $productCnt['cnt'];
            }
        }
    }

    /**
     * Get total amount for user
     *
     * @param int / bool $companyId
     *
     * @return integer
     * */
    public function getTotalAmount($companyId = false){
        $this->_totalAmount = 0;
        $this->_countTotalAmount($companyId);
        return $this->_totalAmount;
    }

    /**
     * Count total amount for user
     *
     * @param int / bool $companyId
     *
     * */
    private function _countTotalAmount($companyId = false){
        if($companyId){

            if(array_key_exists($companyId, $this->_cart[$this->_currentUserKey])){
                foreach(Product::whereIn('id', array_keys($this->_cart[$this->_currentUserKey][$companyId]['products']))->get([
                    'id',
                    'product_price'
                ]) as $singleProduct){
                    $this->_totalAmount = $this->_totalAmount + $this->_cart[$this->_currentUserKey][$companyId]['products'][$singleProduct->id]['cnt'] * $singleProduct->product_price;
                }
            }
        }else{
            die('Surprise, you are here !!!');
        }
    }
}

?>