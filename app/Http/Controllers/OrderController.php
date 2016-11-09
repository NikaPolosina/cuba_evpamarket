<?php

namespace App\Http\Controllers;
use App\Company;
use App\Product;
use \App\ProductOrder;
use App\Region;
use App\City;
use App\Order;
use App\OrderProduct;
use App\StatusSimple;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\StatusOwner;
use App\UserMoney;
use App\Group;
use Creitive\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Cookie;
use App\AdditionParam;
class OrderController extends Controller{
    protected $_breadcrumbs;



    public function __construct(Request $request, Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider('<img style="display: inline-block;  height: 37px;" src="/img/system/next-bread.png">');
    }

    public function createOrder(Request $request, CartController $cartController){


        if(!Auth::user()){
            return view('auth.login');
        }


        $company = Company::find($request['company_id']);
        $keys = array();
        foreach($request['product'] as $id=>$product){
            if(isset($product['checked'])){
                $keys[] = $id;
            }
        }
        $products = Product::whereIn('id', $keys)->select(['id', 'product_name', 'product_description', 'product_price'])->get();
        $products =  IndexController::showProduct($products);

        //$total = $cartController->getTotalAmount($company->id);


        $total = 0;
        foreach($products as $currentProduct){
            $currentProduct->cnt = 1;
            if(array_has($request['product'], $currentProduct->id)){
                $currentProduct->cnt = $request['product'][$currentProduct->id]['cnt'];
            }
            $currentProduct->total = $currentProduct->product_price*$currentProduct->cnt;
            $total = $total+$currentProduct->total;

            if(array_key_exists('add_param', $request->product[$currentProduct->id])){
                $currentProduct->value = $request->product[$currentProduct->id]['add_param'];
            }else{
                $currentProduct->value = array();
            }
        }

        $user = Auth::user();
        $info_user =  $user->getUserInformation;
        $region = Region::where('id_region', $info_user['region_id'])->first();
        $city = City::where('id_cities', $info_user['city_id'])->first();
        
        $owner = $company->getUser;
        $status = StatusOwner::where('key','sending_buyer')->get();

        $total_discount = 0;
        $t = self::getTotalCompanyAmount($company, StatusOwner::where('key','sending_buyer')->first(), $user) + $total;

        if(Auth::user()->getGroup()->where('company_id', $company->id)->count()){
            $t = $total + Auth::user()->getGroup()->where('company_id', $company->id)->max('money');
        }

        $discount = $company->getDiscountAccumulativ()->where('from', '<=', $t)->orderBy('from', 'desc')->first();

        if($discount){
            $total_discount = ($total*$discount['percent'])/100;
            $persent = $discount['percent'];
        }else{
            $total_discount = 0;
            $persent = null;
        }


        foreach ($products as $product) {
            $product->addParam = array();
            if(array_key_exists($product->id, $request->product)){
                if(array_key_exists('add_param', $request->product[$product->id])){
                    $product->addParam = $request->product[$product->id]['add_param'];
                }
            }
        }

        $addParam = array();
        if(count($request->product)){
            foreach ($request->product as $single) {
                if(array_key_exists('add_param', $single) && is_array($single['add_param'])){
                    $addParam = array_merge($addParam, array_keys($single['add_param']));
                }
            }
        }
        $addParam = array_unique($addParam);
        $addParam = AdditionParam::whereIn('key', $addParam)->get()->toArray();
        foreach ($addParam as $key => $value) {
            $addParam[$key]['value'] = json_decode($value['value'], true);
        }

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Корзина', '/cart');
        $this->_breadcrumbs->addCrumb('Офрмление заказа', '/order');

        return view('order.create')
            ->with('addParam', $addParam)
            ->with('user', $user)
            ->with('info_user', $info_user)
            ->with('region', $region)
            ->with('city', $city)
            ->with('company', $company)
            ->with('total_price', $total)
            ->with('total_discount', $total_discount)
            ->with('percent', $persent)
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('products', $products);
    }

    public function ready(Request $request){

        $this->validate($request, [ 'company_id' => 'required',
                                    'name' => 'required',
                                    'surname' => 'required',
                                    'phone' => 'required', ]);
        $company = Company::find($request['company_id']);
        $userOwner = $company->getUser;
        $userSeller = Auth::user()['id'];
        $id = array();

        foreach($request['product'] as $product_id=>$cnt){
            $id[] = $product_id;
        }
        $products = Product::whereIn('id', $id)->select(['id', 'product_name', 'product_description', 'product_price'])->get();
        $total = 0;
        foreach($products as $currentProduct){
            $currentProduct->cnt = 1;
            if(array_has($request['product'], $currentProduct->id)){
                $currentProduct->cnt = $request['product'][$currentProduct->id]['cnt'];
            }
            $currentProduct->total = $currentProduct->product_price*$currentProduct->cnt;
            $total = $total+$currentProduct->total;
        }

        /*--------------------------*/
        $owner = $company->getUser;
        $status = StatusOwner::where('key','sending_buyer')->get();

        $order = Order::select('order.*', DB::raw('sum(order.total_price) as total_sum'))
            ->where('simple_user_id', $userSeller)
            ->where('owner_user_id', $owner[0]['id'])
            ->where('status', $status[0]['id'])
            ->first();
//        dd($company);
        $order = self::getTotalCompanyAmount($company, StatusOwner::where('key','sending_buyer')->first(), Auth::user());

        $t = $total + $order;
        if(Auth::user()->getGroup()->where('company_id', $company->id)->count()){
            $t = $total + Auth::user()->getGroup()->where('company_id', $company->id)->max('money');
        }
        $discount = $company->getDiscountAccumulativ()->where('from', '<=', $t)->orderBy('from', 'desc')->first();

        if($discount){
            $total_discount = ($total*$discount['percent'])/100;
            $persent = $discount['percent'];
        }else{
            $total_discount = 0;
            $persent = 0;
        }
        /*--------------------------*/
        $a =  $total - $total_discount;

        $satus = StatusOwner::where('key', '=', 'not_processed')->get();

        DB::beginTransaction();

        try{
            $order = Order::create([
                'simple_user_id'    => $userSeller,
                'owner_user_id'     => $userOwner[0]['id'],
                'status'            => $satus[0]['id'],
                'total_price'       => $total,
                'discount_price'    => $a,
                'percent'           => $persent,
                'order_phone'       => $request['phone'] ,
                'region'            => $request['region_id'] ,
                'city'              => $request['city_id'] ,
                'street'            => $request['street'] ,
                'address'           => $request['address'] ,
                'name'              => $request['name'] ,
                'surname'           => $request['surname'] ,
            ]);

            foreach($products as $currentProduct){

                $add_param = '';
                if(array_key_exists($currentProduct->id, $request->product)){
                    if(array_key_exists('add_param', $request->product[$currentProduct->id])){
                        $add_param = json_encode($request->product[$currentProduct->id]['add_param']);
                    }
                }

                $r = ProductOrder::create([
                    'product_id'    => $currentProduct['id'] ,
                    'cnt'           => $currentProduct['cnt'] ,
                    'price'         => $currentProduct['product_price'] ,
                     'order_id'         => $order->id ,
                    'add_param'         => $add_param
                ]);
            }

            $company->getOrder()->save($order);

            DB::commit();



            $cart = array();
            if($request->cookie('cart')){
                $cart = $request->cookie('cart');
            }

            $k = (Auth::user()) ? Auth::user()->id.'_id' : '0_id';
            $cart[$k] =  (isset($cart[$k])) ? $cart[$k] : array();

//            dd($cart);

            if(array_key_exists($company['id'], $cart[$k]) && count($cart[$k][$company['id']]['products'])){
                foreach($products as $currentProduct){
                    if(array_key_exists($currentProduct['id'], $cart[$k][$company['id']]['products'])){
                        unset($cart[$k][$company['id']]['products'][$currentProduct['id']]);
                    }
                    if(!count($cart[$k][$company['id']]['products'])){
                        unset($cart[$k][$company['id']]);
                        break;
                    }
                }
            }

//    dd($cart);
        }catch(\Exception $e){
                DB::rollback();
                return Redirect::back();
        }


        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Корзина', '/cart');
        $this->_breadcrumbs->addCrumb('Оформление заказа', '/order-ready');

        Cookie::queue('cart', $cart);

        return view('order.ready')
            ->with('breadcrumbs', $this->_breadcrumbs);
//            ->withCookie('cart', $cart);
    }

    public function showOrder($id, $status=0){
        $id_status = $status;
        $company = Company::find($id);

        if(!$status){
            $order  = $company->getOrder()->with('getStatusOwner')->get();
        }else{
            $order = $company->getOrder()->where('status', $status)->with('getStatusOwner')->get();

        }

        $status = StatusOwner::get();
        $myStatus = $company->getOrder()->select(['status'])->groupBy('status')->with(['getStatusOwner'=>function($query){
            $query->select(['id', 'title']);
        }])->get();

      /*  foreach($myStatus as $item){
            $status = StatusOwner::find($item['status']);
            if($status['key'] == 'not_processed'){
                return redirect('/order-by-status/'.$company['id'].'/'.$status['id']);
            }

        }*/
        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Мои магазины', '/my_shops');
        $this->_breadcrumbs->addCrumb('Мои заказы по магазину - '.$company->company_name, '/order-by-status/'.$id.'/'.$id_status);

        return view('order.orderListShop')
            ->with('company', $company)
            ->with('order', $order)
            ->with('myStatus', $myStatus)
            ->with('status', $status)
            ->with('breadcrumbs', $this->_breadcrumbs);
    }
    

    public function changStatus($order, $status_id){
        $status = StatusOwner::find($status_id);
        $order = Order::find($order);

        if($status['key'] == 'sending_buyer'){
            $user_id = $order->simple_user_id;
            $company_id = $order->getCompany[0]['id'];
            $totalHistoryAmount = OrderController::getTotalCompanyAmount($order->getCompany[0], StatusOwner::where('key','sending_buyer')->first(), Auth::user());
            $totalHistoryOld = UserMoney::where('user_id', $user_id)->where('company_id', $company_id)->first();
            if($totalHistoryOld){
                $totalHistoryAmount += $totalHistoryOld->money;
            }
            $userMoney = UserMoney::firstOrNew(array('user_id' => $user_id, 'company_id' => $company_id));
            $userMoney->money = $totalHistoryAmount + $order->discount_price;
            $userMoney->save();

            $user = User::find($order->simple_user_id);
            $group = $user->getGroup()->where('company_id', $company_id)->get();
            foreach($group as $item){

                $item->money += $order->discount_price;
                $item->save();
            }
            
        }
        $order->status = $status['id'];
        $order->save();
        return redirect()->back();

        
    }

    public function showSimpleOrder($id){


      $order = Order::find($id);

      $products =  Product::whereIn('products.id', ProductOrder::where('order_id', $id)->get()->lists(['product_id']))
          ->join('product_order', function($join) use ($id){
              $join->on('products.id', '=', 'product_order.product_id')->where('product_order.order_id', '=',$id);
          })
          ->get(['products.*', 'product_order.cnt', 'product_order.add_param']);

        foreach ($products as $value) {
            $value->add_param = json_decode($value->add_param, true);
        }

        if(count($products))
            $order->products = IndexController::showProduct($products);

        if(Auth::user()->hasRole('company_owner')){
            $this->_breadcrumbs->addCrumb('Домой', '/login-user');
            $this->_breadcrumbs->addCrumb('Мои магазины', '/my_shops');
            $this->_breadcrumbs->addCrumb('Мои заказы по магазину - '.$order->products['0']->getCompany['0']->company_name, '/order-by-status/'.$order->products['0']->getCompany['0']->id.'/'.$order->status);
            $this->_breadcrumbs->addCrumb('Заказ', '/show-simple-order/'.$id);
        }
        if(Auth::user()->hasRole('simple_user')){
            $this->_breadcrumbs->addCrumb('Домой', '/login-user');
            $this->_breadcrumbs->addCrumb('Мои заказы', '/show-list-order-simple');
            $this->_breadcrumbs->addCrumb('Заказ', '/show-simple-order/'.$id);
        }


        return view('order.simple')
            ->with('order', $order)
            ->with('breadcrumbs', $this->_breadcrumbs);

    }

    public function showSimpleOrderList(){
        $order = Order::where('simple_user_id', '=', Auth::user()->id)->with('getFeedback')->with(['getProductOrder' => function($query){
            $query->with('getProductId');
        }])->get();
        $status = StatusSimple::get();
        $st = StatusOwner::where('key', 'sending_buyer')->get();
        $finishOrder = Order::where('simple_user_id', '=', Auth::user()->id)->where('status', $st['0']->id)->with(['getProductOrder' => function($query){
            $query->with('getProductId');
        }])->get();
        $activeOrder = Order::where('simple_user_id', '=', Auth::user()->id)->where('status', '!=', $st['0']->id)->get();
        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Мои заказы', '/show-list-order-simple');
  


        return view('order.orderListShopSimple')
            ->with('order', $order)
            ->with('finishOrder', $finishOrder)
            ->with('activeOrder', $activeOrder)
            ->with('status', $status)
            ->with('breadcrumbs', $this->_breadcrumbs);
    }

    /**
     * Get total amount for single company for period
     *
     * @param int $companyId
     * @param int $days
     *
     * @return integer
     * */
    public static function getAmount($companyId, $days){
        $amount = 0;
        $orsders = Company::find($companyId)
            ->getOrder()
            ->where('status', 16)
            ->where('updated_at', '>=',  Carbon::today()->subDays($days))
            ->get();
        if(count($orsders)){
            foreach ($orsders as $order) {
                $amount = $amount+$order->total_price;
            }
        }
        return $amount;
    }

    public static function getTotalCompanyAmount(Company $company, StatusOwner $statusOwner, User $user){
        
        return $company->getOrder()->where('simple_user_id', $user->id)->where('status', $statusOwner->id)->get()->sum('total_price');

    }

}