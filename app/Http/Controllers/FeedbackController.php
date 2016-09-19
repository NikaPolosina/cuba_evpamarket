<?php

namespace App\Http\Controllers;

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

    public function start($id){

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Мои заказы', '/show-list-order-simple');
        $this->_breadcrumbs->addCrumb('Отзыв', '/feedback-view/'.$id);


        $order = Order::find($id)->with(['getProductOrder' => function($query){
            $query->with('getProductId');
        }])->with('getCompany')->first();

        foreach($order->getProductOrder as $item){
            $item->getProductId =  IndexController::showProduct($item->getProductId);

        }

        return view('order.feedback')
            ->with('order', $order)
            ->with('breadcrumbs', $this->_breadcrumbs);

    }
    public function startSetup(Request $request, $id){
        dd($request->all());
    }

}