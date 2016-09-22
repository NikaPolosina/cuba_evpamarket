<?php
namespace App\Http\Controllers;

use App\FeedbackProduct;
use Validator;
use App\Category;
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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use Creitive\Breadcrumbs\Breadcrumbs;

class FeedbackController extends Controller{
    protected $_breadcrumbs;

    public function __construct(Request $request, Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
    }

    protected function myValidator(array $data){
        return Validator::make($data, [
            'rate' => 'required',
            'msg'  => 'required'
        ]);
    }

    public function start($id){

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Мои заказы', '/show-list-order-simple');
        $this->_breadcrumbs->addCrumb('Отзыв', '/feedback-view/' . $id);
        $order = Order::where('id', $id)->with([
            'getProductOrder' => function ($query){
                $query->with('getProductId');
            }
        ])->with('getCompany')->first();
        foreach($order->getProductOrder as $item){
            $item->getProductId = IndexController::showProduct($item->getProductId);
        }
        return view('order.feedback')->with('order', $order)->with('breadcrumbs', $this->_breadcrumbs);
    }

    public function startSetup(Request $request, $id){

        $id_order_feed = $id;
        $order = Order::where('id', $id)->with('getProductOrder')->first();
        $error = array();
        foreach($request->product as $id => $item){
            $v = $this->myValidator($item);
            $v->setAttributeNames([
                'rate' => 'Рейтинг',
                'msg'  => 'Отзыв',
            ]);
            if($v->fails()){
                $error[$id] = $v->messages();
            }
        }
        if(count($error) > 0){
            Session::flash('message', $error);
            return redirect()->back()->withInput();
        }
        $order_ids = [ ];


        foreach($order->getProductOrder as $or){
            $order_ids[] = $or->product_id;
        }



        foreach($request->product as $id => $item){
            
            if(in_array($id, $order_ids)){
                $newFeedback = new FeedbackProduct([
                    'order_id'   => $id_order_feed,
                    'product_id' => $id,
                    'user_id'    => Auth::user()->id,
                    'rating'     => $item['rate'],
                    'feedback'   => $item['msg'],
                ]);

            }else{
                return redirect()->back()->with('error', 'Something went wrong.');
            }
            $newFeedback->save();
        }
        return redirect ('/show-list-order-simple');
    }

    public function showMyFeed($product_id, $order_id, $user_id){
        echo($product_id);
        echo($order_id);
        echo($user_id);
        die('Surprise, you are here !!!');
        

    }
}