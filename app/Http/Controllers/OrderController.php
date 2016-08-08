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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\StatusOwner;


class OrderController extends Controller{

    public function createOrder(Request $request){

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

        $order = Order::select('order.*', DB::raw('sum(order.total_price) as total_sum'))
            ->where('simple_user_id', $user->id)
            ->where('owner_user_id', $owner[0]['id'])
            ->where('status', $status[0]['id'])
            ->first();
        $total_discount = 0;
        if(($total - $order->total_sum ) < 0 ){
            $persent = $company->getDiscountAccumulativ()->where('from', '<=', $order->total_sum )->get();

        }else{
            $persent = $company->getDiscountAccumulativ()->where('from', '<=', $total)->get();

        }

        if(count($persent) > 0){
            $total_discount = ($total*$persent[0]['percent'])/100;
        }

        if(count($persent)){
            $persent = $persent[0];
        }else{
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

        $satus = StatusOwner::where('key', '=', 'not_processed')->get();


        DB::beginTransaction();
        try{
            $order = Order::create([
                'simple_user_id'    => $userSeller,
                'owner_user_id'     => $userOwner[0]['id'],
                'status'            => $satus[0]['id'],
                'total_price'       => $total,
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

    public function showOrder($id){
        $company = Company::find($id);
        $order  = $company->getOrder()->with('getStatusOwner')->get();
        $status = StatusOwner::get();
        return view('order.orderListShop')
            ->with('company', $company)
            ->with('order', $order)
            ->with('status', $status);
    }


    public function changStatus($order, $status_id){
        $status = StatusOwner::find($status_id);
        $order = Order::find($order);

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
            ->where('updated_at', '>=',  Carbon::now()->subDays($days))
            ->get();
        if(count($orsders)){
            foreach ($orsders as $order) {
                $amount = $amount+$order->total_price;
            }
        }
        return $amount;
    }

}