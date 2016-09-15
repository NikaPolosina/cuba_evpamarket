<?php
namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;
use Creitive\Breadcrumbs\Breadcrumbs;


class LikeController extends Controller{
    protected $_breadcrumbs;

    public function __construct(Request $request, Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
    }

    public function index(Request $request){
        $product = [ ];
        $curentUser = Auth::user();
        $product = $curentUser->getProduct;
        $product = IndexController::showProduct($product);

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Избранное', '/like');

        return view('product.like')->with('product', $product)->with('breadcrumbs', $this->_breadcrumbs);
    }

    public function like(Request $request){
        $curentUser = Auth::user();
        if($curentUser->getProduct()->where('product_id', $request['id'])->count() <= 0){
            $curentUser->getProduct()->attach($request['id']);
        }
        $cnt = count($curentUser->getProduct);
        return response()->json([
            'success'     => true,
            'product_cnt' => $cnt,
            'product'     => Product::find($request->input('id')),
        ], 200);
    }

    public function destroy(Request $request){
        $curentUser = Auth::user();
        $curentUser->getProduct()->detach($request['id']);
        $cnt = count($curentUser->getProduct);
        return response()->json([
            'success'     => true,
            'product_cnt' => $cnt,
            'product'     => Product::find($request->input('id')),
        ], 200);
    }

    public static function getProductCount(Request $request){
        $cnt = 0;
        if(Auth::check()){
            $curentUser = Auth::user();
            $cnt = count($curentUser->getProduct);
        }
        return $cnt;
    }
}

?>