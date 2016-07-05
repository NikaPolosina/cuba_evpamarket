<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LikeController;

class HeadComposer{
    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function compose(View $view){
        $view->with('product_cnt', CartController::getProductCount($this->request));
        $view->with('product_cnt_like', LikeController::getProductCount($this->request));
    }
}