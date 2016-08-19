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


class OrderController extends Controller{

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
        }


        $user = Auth::user();
        $info_user =  $user->getUserInformation;
        $region = Region::find($info_user['region_id']);
        $city = City::find($info_user['city_id']);

        $owner = $company->getUser;
        $status = StatusOwner::where('key','sending_buyer')->get();




        $total_discount = 0;
        $t = self::getTotalCompanyAmount($company, StatusOwner::where('key','sending_buyer')->first(), $user) + $total;


        $discount = $company->getDiscountAccumulativ()->where('from', '<=', $t)->orderBy('from', 'desc')->first();


        if($discount){
            $total_discount = ($total*$discount['percent'])/100;
            $persent = $discount['percent'];
        }else{
            $total_discount = 0;
            $persent = null;
        }

        return view('order.create')
            ->with('user', $user)
            ->with('info_user', $info_user)
            ->with('region', $region)
            ->with('city', $city)
            ->with('company', $company)
            ->with('total_price', $total)
            ->with('total_discount', $total_discount)
            ->with('percent', $persent)
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
                $order_product = ProductOrder::create([
                    'product_id'    => $currentProduct['id'] ,
                    'cnt'           => $currentProduct['cnt'] ,
                    'price'         => $currentProduct['product_price'] ,
                     'order_id'         => $order->id ,
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


        }catch(\Exception $e){
                DB::rollback();
                return Redirect::back();
        }


        return response()->view('order.ready')->withCookie(cookie('cart', $cart));
    }

    public function showOrder($id, $status=0){


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


        return view('order.orderListShop')
            ->with('company', $company)
            ->with('order', $order)
            ->with('myStatus', $myStatus)
            ->with('status', $status);
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
            $userMoney->money = $totalHistoryAmount + $order->total_price;
            $userMoney->save();
            
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
          ->get(['products.*', 'product_order.cnt']);

        if(count($products))
            $order->products = IndexController::showProduct($products);
   
        

        return view('order.simple')
            ->with('order', $order);

    }
    public function showSimpleOrderList(){
        $order =  Order::where('simple_user_id', '=', Auth::user()->id)->get();
        $status = StatusSimple::get();
        return view('order.orderListShopSimple')
            ->with('order', $order)
            ->with('status', $status);

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