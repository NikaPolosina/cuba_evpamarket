<?php

namespace App\Http\Controllers;
use App\Company;
use App\Product;
use \App\ProductOrder;
use App\Region;
use App\City;
use App\Order;
use App\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\StatusOwner;


class OrderController extends Controller{

    public function createOrder(Request $request){
        if(!Auth::user()){
            die(' не залогинен!!!');
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
        return view('order.create')
            ->with('user', $user)
            ->with('info_user', $info_user)
            ->with('region', $region)
            ->with('city', $city)
            ->with('company', $company)
            ->with('total_price', $total)
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

        $cart = $request->cookie('cart');

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

            if(array_key_exists($company['id'], $cart) && count($cart[$company['id']]['products'])){
                foreach($products as $currentProduct){
                    if(array_key_exists($currentProduct['id'], $cart[$company['id']]['products'])){
                        unset($cart[$company['id']]['products'][$currentProduct['id']]);
                    }
                    if(!count($cart[$company['id']]['products'])){
                        unset($cart[$company['id']]);
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
        dd($status);
    }

}