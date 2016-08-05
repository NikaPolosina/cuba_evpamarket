<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LikeController;

class HeadComposer{
    protected $request;
    protected $cartController;

    public function __construct(Request $request, CartController $cartController){
        $this->request = $request;
        $this->cartController = $cartController;
    }

    public function compose(View $view){
        $view->with('product_cnt', $this->cartController->getTotalProductCnt());
        $view->with('product_cnt_like', LikeController::getProductCount($this->request));
    }
}