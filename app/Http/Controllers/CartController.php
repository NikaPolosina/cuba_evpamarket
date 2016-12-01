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

//        dd($cart);

        $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';

        $cart[$k] = (isset($cart[$k])) ? $cart[$k] : array();

        $addParam = array();

        if($cart[$k]){
            foreach($cart[$k] as $key => $company){
                //dd($company);
                $companies[$key]['company'] = Company::find($key);

                $companies[$key]['products'] = $companies[$key]['company']->getProducts()->whereIn('id', array_keys($company['products']))->with('getCategory')->get();

                foreach ($companies[$key]['products'] as $num => $prod) {
                    if(array_key_exists($prod->id, $company['products']) && array_key_exists('add_param', $company['products'][$prod->id])){
                        $companies[$key]['products'][$num]->value = json_decode($company['products'][$prod->id]['add_param'], true);
                        if(is_array($companies[$key]['products'][$num]->value)){
                            $addParam = array_merge($addParam, array_keys($companies[$key]['products'][$num]->value));
                        }
                    }else{
                        $companies[$key]['products'][$num]->value = array();
                    }
                }

                $addParam = array_unique($addParam);

                $companies[$key]['products'] = IndexController::showProduct($companies[$key]['products']);


                foreach($companies[$key]['products'] as $value){
                    if(array_key_exists($value->id, $company['products'])){
                        $value->cnt = $company['products'][$value->id]['cnt'];
                    }else{
                        $value->cnt = 0;
                    }
                }


                $companies[$key]['totalAmount'] = $this->getTotalAmount($key);
                 if(Auth::user()){
                     $companies[$key]['totalHistoryAmount'] = OrderController::getTotalCompanyAmount($companies[$key]['company'], StatusOwner::where('key','sending_buyer')->first(), Auth::user());
                     $companies[$key]['total'] = $companies[$key]['totalAmount'] + $companies[$key]['totalHistoryAmount'];

                     if(Auth::user()->getGroup()->where('company_id', $key)->count()){

                         $companies[$key]['totalHistoryAmount'] = Auth::user()->getGroup()->where('company_id', $key)->max('money');
                         $companies[$key]['total'] = $companies[$key]['totalAmount'] + $companies[$key]['totalHistoryAmount'];
                     }
                     
                     $companies[$key]['discount'] = $companies[$key]['company']->getDiscountAccumulativ()->where('from', '<=', $companies[$key]['total'])->orderBy('from', 'desc')->first();

                 }

            }

        }

        $addParam = AdditionParam::whereIn('key', $addParam)->get();
        foreach ($addParam as $value) {
            $value->value=json_decode($value->value, true);
        }

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Корзина', '/cart');
        return view('product.cart')
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('addParam', $addParam)
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

        $id = $request['id'];
        $cart = array();
        $cnt = 0;

        if($request->cookie('cart')){
            //            $cart = $request->cookie('cart');

            if($request->cookie('cart')){
                $cart = $request->cookie('cart');
            }
            $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
            $cart[$k] = (isset($cart[$k])) ? $cart[$k] : array();
            $currentCompany = Product::find($request->input('id'))->getCompany()->first();
            $currentCompanyId = $currentCompany->id;
            $cn = 0;
            if(array_key_exists($currentCompanyId, $cart[$k])){
                $cn = $cart[$k][$currentCompanyId]['products'][$request->input('id')]['cnt'];
                unset($cart[$k][$currentCompanyId]['products'][$request->input('id')]);
                $current_company_cnt = count($cart[$k][$currentCompanyId]['products']);
                if(!$current_company_cnt){
                    unset($cart[$k][$currentCompanyId]);
                }
            }

            foreach($cart[$k] as $company){
                foreach($company['products'] as $product){
                    $cnt += $product['cnt'];
                }
            }
            $this->_userCartProductCnt();

            return response()->json([
                'success'            => true,
                'product_cnt'        => $cnt,
                'product'            => Product::find($request->input('id')),
                'total_in_shop'      => $this->_totalCnt,
                'in_current_company' => $current_company_cnt
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

            if(array_key_exists($currentCompanyId, $this->_cart[$this->_currentUserKey])){
                if(array_key_exists($singleProduct['product_id'], $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'])){
                    $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'][$singleProduct['product_id']]['cnt'] = $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'][$singleProduct['product_id']]['cnt'] + $singleProduct['cnt'];
                }else{
                    $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'][$singleProduct['product_id']]['cnt'] = $singleProduct['cnt'];
                    $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'][$singleProduct['product_id']]['add_param'] = $singleProduct['add_param'];
                }
            }else{
                $this->_cart[$this->_currentUserKey][$currentCompanyId] = array();
                $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'][$singleProduct['product_id']]['cnt'] = $singleProduct['cnt'];
                $this->_cart[$this->_currentUserKey][$currentCompanyId]['products'][$singleProduct['product_id']]['add_param'] = $singleProduct['add_param'];
            }
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