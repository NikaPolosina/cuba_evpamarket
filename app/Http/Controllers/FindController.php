<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Session;
use Auth;
use Illuminate\Http\Request;
use App\Product;
use App\Category;


class FindController extends Controller{
    public function findProduct(Request $request, CategoryController $category){

        if($request->input('find')){
            $res = Product::search($request->input('find'))->get();
            $productAll = IndexController::showProduct($res);

            return view('find')
                ->with('productAll', $productAll)
                ->with('category', $category->getAllCategoris())
                ->with('search', $request->input('find'));
        }

        return view('welcome');
    }
    public function findByCategory($id, CategoryController $category){

        $data = Product::where('category_id', $id)->paginate(12);

        $vip_category = Category::where('parent_id', $id)->get();
        $data = IndexController::showProduct($data);


        return view('category.findByCategory')
            ->with('data', $data)
            ->with('category' ,$category->getAllCategoris())
            ->with('vip_category', $vip_category);
    }
}