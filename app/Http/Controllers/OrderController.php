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

    //Метод направляющий на страницу заполнения заказа продавцом в ручном режиме.
    public function orderRegistrHandle($id, $shop){
        $user = User::where('id', $id)->with('getUserInformation')->first();
        $seller =  User::where('id', Auth::user()->id)->with(['getCompanies' =>function($query) use ($shop){
            $query->where('id', $shop);
        }])->first();

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Магазин - '.$seller->getCompanies[0]['company_name'], '/product-editor/'.$seller->getCompanies[0]['id']);
        $this->_breadcrumbs->addCrumb('Офорление заказа в ручном режиме', '/add-handle-order/'.$id.'/'.$shop);

        $region = Region::where('id_region', $user->getUserInformation->region_id)->first();
        $city = City::where('id_cities', $user->getUserInformation->city_id)->first();
        $money = UserMoney::where('user_id', $user->id)->where('company_id', $seller->getCompanies[0]['id'])->first();

        $group = $user->getGroup()->where('company_id', $shop)->first();
        if($group){
            $money = $group;
        }

        return view('order.createHandle')
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('seller', $seller)
            ->with('region', $region)
            ->with('city', $city)
            ->with('money', $money)
            ->with('user', $user);
    }

    //Метод сохранения заказа в ручном режиме.
    public function orderHandleReady(Request $request, $id = null){

        if($id){
            $company = Company::find($id);//Обьект компании.

            $this->_breadcrumbs->addCrumb('Домой', '/login-user');
            $this->_breadcrumbs->addCrumb('Магазин - '.$company->company_name, '/product-editor/'.$company->id);
            $this->_breadcrumbs->addCrumb('Завершение заказа в ручном режиме', '/');

            return view('order.readyHandle')
                ->with('breadcrumbs', $this->_breadcrumbs);
           }


        $this->validate($request, [ 'company_id' => 'required',
                                    'user_id' => 'required',
                                    'phone' => 'required', ]);//Проводим валидацию полей. Данные поля должны быть обязательными.
        $company = Company::find($request['company_id']);//Обьект компании.
        $seller = $company->getUser->first();//Обьект продавца.
        $user = User::where('id', $request['user_id'])->first();//Обьект покупателя.
        $satus = StatusOwner::where('key', 'sending_buyer')->first();//Берем обьект status owner для того что бы поставить статус заказа при оформлении что он завершенный.
        $group = $user->getGroup()->where('company_id', $request['company_id'])->first();//Если покупатель сосоит в группе то берем обект этой группы по магазину.
        $money = UserMoney::where('user_id', $user->id)->where('company_id', $request['company_id'])->first();//Обьект UserMoney.

        if($group){
            $t = $group->money + $request['total_price'];
        }else{
            if(!$money){
                $t = 0;
            }else{
                $t = $money->money + $request['total_price'];

            }
        }//Если покупатель состоит в группе, то нужно взять сумму для учета скидки с группы.

        $discount = $company->getDiscountAccumulativ()->where('from', '<=', $t)->orderBy('from', 'desc')->first();
        if($discount){
            $total_discount = ($request['total_price']*$discount['percent'])/100;//скидка в рублях
            $persent = $discount['percent'];//скидка в процентах
        }else{
            $total_discount = 0;
            $persent = 0;
        }//Выщитываем скидку

        $a =  $request['total_price'] - $total_discount;//Сумма по заказу с учетем скидки
        $order = new Order([
            'simple_user_id' => $user->id,
            'owner_user_id'  => $seller->id,
            'status'         => $satus->id,
            'total_price'    => $request['total_price'],
            'discount_price' => $a,
            'percent'        => $persent,
            'hand'           => 1,
            'order_phone'    => $request['phone'],
            'region'         => $request['region_id'],
            'city'           => $request['city_id'],
            'street'         => $request['street'],
            'address'        => $request['address'],
            'name'           => $request['name'],
            'surname'        => $request['surname'],
            'note'           => $request['note'],
        ]);//Создаем новый заказ

        if($money){
            $money->money = $money->money+$a;//Добавляем в таблицу user_money в ячейку money сумму по текущему заказу.
        }else{
            $money = new UserMoney([
                'user_id' => $user->id,
                'company_id' => $request['company_id'],
                'money' => $a,
            ]);
        }//Если покупатель покупает в первы, то нужно создать запись в таблице user_money и занести туда сумму текущей покупки.

        $money->save();//Сохраняем данные по таблице user_money.
        $order->save();//Сохраняем наш заказ (таблица orders)
        $company->getOrder()->save($order);//Сохраняем запись в таблице company_order (создаем связь в связующей таблице между заказом и магазином).
        if($group){
            $group->money = $group->money+$a;
            $group->save();
        }//Если покупатель состоит в группе то добавляем сумму по даному заказу к общему колличеству денег в группе и сохраняем.


        header("Location:/order-ready-handle/".$company->id );
        exit;
    }

    //Метод который направляет на страницу просмотра правельности заполнение заказа (покупатель просматривает свой заказ визуально. Типа бланка.)
    public function createOrder(Request $request, CartController $cartController){

        if(!Auth::user()){
            return view('auth.login');
        }

        $order = $request['order'];
        $cart = array();

        $user = Auth::user();
        $info_user =  $user->getUserInformation;
        $region = Region::where('id_region', $info_user['region_id'])->first();
        $city = City::where('id_cities', $info_user['city_id'])->first();

        if($request->cookie('cart')){
            $cart = $request->cookie('cart')[Auth::user()->id.'_id'];
        }

        foreach($order as $id => $product){
            $order['totalAmount'] = 0;
            foreach ($product['product'] as $k => $single) {

                if(!isset($single['checked'])){
                    unset($order['product'][$k]);
                }else{
                    $product = Product::find($cart[$id]['products'][$k]['product_id']);

                    $product->cnt = $single['cnt'];
                    $cart[$id]['products'][$k]['add_param'] = json_decode($cart[$id]['products'][$k]['add_param'], true);
                    $product->product_price = $cart[$id]['products'][$k]['add_param']['current_price'];
                    $product->value = $cart[$id]['products'][$k]['add_param']['add_param'];
                    $product =  IndexController::showProduct($product);
                    $product->hash = $k;

                    $order['totalAmount'] = $order['totalAmount'] + ($product->cnt*$product->product_price);

                    $order['product'][$k] = $product;
                }
            }


            if(count($order['product'])){
                $order['company'] = Company::find($id);

                $order['totalHistoryAmount'] = OrderController::getTotalCompanyAmount($order['company'], StatusOwner::where('key','sending_buyer')->first(), Auth::user());

                $order['total'] = $order['totalAmount'] + $order['totalHistoryAmount'];

                if(Auth::user()->getGroup()->where('company_id', $id)->count()){
                    $order['totalHistoryAmount'] = Auth::user()->getGroup()->where('company_id', $id)->max('money');
                    $order['total'] = $order['totalAmount'] + $order['totalHistoryAmount'];
                }

                $order['discount'] = $order['company']->getDiscountAccumulativ()->where('from', '<=', $order['total'])->orderBy('from', 'desc')->first();
            }
        }

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Корзина', '/cart');
        $this->_breadcrumbs->addCrumb('Офрмление заказа', '/order');


        $order['total_discount'] = ($order['total']*$order['discount']->percent)/100;

        //$order['total'] = $order['total'] - $order['total_discount'];



        return view('order.create')
            ->with('user', $user)
            ->with('info_user', $info_user)
            ->with('region', $region)
            ->with('city', $city)
            ->with('company', $order['company'])
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('products', $order['product'])
            ->with('total_price', $order['total'])
            ->with('total_discount', $order['total_discount'])
            ->with('percent', $order['discount']->percent);
    }

    public function ready(Request $request){
        $this->validate($request, [ 'company_id' => 'required',
                                    'name' => 'required',
                                    'surname' => 'required',
                                    'phone' => 'required', ]);

        $company = Company::find($request['company_id']);
        $userOwner = $company->getUser;
        $userSeller = Auth::user()['id'];

        $owner = $company->getUser;
        $status = StatusOwner::where('key','sending_buyer')->get();

        $order = Order::select('order.*', DB::raw('sum(order.total_price) as total_sum'))
            ->where('simple_user_id', $userSeller)
            ->where('owner_user_id', $owner[0]['id'])
            ->where('status', $status[0]['id'])
            ->first();
        $order = self::getTotalCompanyAmount($company, StatusOwner::where('key','sending_buyer')->first(), Auth::user());










        if($request->cookie('cart')){
            $cart = $request->cookie('cart')[Auth::user()->id.'_id'];
        }


        $cOrder = $request->product;

        $cOrder['totalAmount'] = 0;

        foreach ($request->product as $k => $single) {

            $product = Product::find($cart[$company->id]['products'][$k]['product_id']);

            $product->cnt = $single['cnt'];
            $cart[$company->id]['products'][$k]['add_param'] = json_decode($cart[$company->id]['products'][$k]['add_param'], true);
            $product->product_price = $cart[$company->id]['products'][$k]['add_param']['current_price'];
            $product->value = $cart[$company->id]['products'][$k]['add_param']['add_param'];
            $product =  IndexController::showProduct($product);
            $product->hash = $k;

            $cOrder['totalAmount'] = $cOrder['totalAmount'] + ($product->cnt*$product->product_price);


            $cOrder['product'][$k] = $product;

        }


        if(count($cOrder['product'])){
            $cOrder['company'] = $company;

            $cOrder['totalHistoryAmount'] = OrderController::getTotalCompanyAmount($cOrder['company'], StatusOwner::where('key','sending_buyer')->first(), Auth::user());

            $cOrder['total'] = $cOrder['totalAmount'] + $cOrder['totalHistoryAmount'];

            if(Auth::user()->getGroup()->where('company_id', $company->id)->count()){
                $cOrder['totalHistoryAmount'] = Auth::user()->getGroup()->where('company_id', $company->id)->max('money');
                $cOrder['total'] = $cOrder['totalAmount'] + $cOrder['totalHistoryAmount'];
            }

            $cOrder['discount'] = $cOrder['company']->getDiscountAccumulativ()->where('from', '<=', $cOrder['total'])->orderBy('from', 'desc')->first();
        }


        $cOrder['total_discount'] = ($cOrder['total']*$cOrder['discount']->percent)/100;


        $satus = StatusOwner::where('key', '=', 'not_processed')->get();

        DB::beginTransaction();

        try{

            $order = Order::create([

                'simple_user_id' => $userSeller,
                'owner_user_id'  => $userOwner[0]['id'],
                'status'         => $satus[0]['id'],
                'total_price'    => $cOrder['total'],
                'discount_price' => $cOrder['total'] - $cOrder['total_discount'],
                'percent'        => $cOrder['discount']->percent,
                'order_phone'    => $request['phone'],
                'region'         => $request['region_id'],
                'city'           => $request['city_id'],
                'street'         => $request['street'],
                'address'        => $request['address'],
                'name'           => $request['name'],
                'surname'        => $request['surname'],
                'note'           => $request['note'],
            ]);

            foreach($cOrder['product'] as $currentProduct){


                $currentProduct->value = json_encode($currentProduct->value);


                $r = ProductOrder::create([
                    'product_id'    => $currentProduct['id'] ,
                    'cnt'           => $currentProduct['cnt'] ,
                    'price'         => $currentProduct['product_price'] ,
                     'order_id'         => $order->id ,
                    'add_param'         => $currentProduct->value
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


            foreach ($cOrder['product'] as $hash => $v) {
                unset($cart[$k][$company->id]['products'][$hash]);
            }



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
            if($order->products)
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