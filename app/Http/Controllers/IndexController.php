<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\File;

class IndexController extends Controller{

    /**
     * Main site page
     * */
    public function Index(ProductsController $product, CompanyController $company, CategoryController $category){
        $productAll = $product->getProductAll();
        $companyAll = $company->getCompanyAll();
        $dir = 'images/large';
        $vip_category = Category::where('vip', 1)->get();
        $slide_img = array_diff(scandir($dir), array(
            '..',
            '.'
        ));

        return view('welcome')->with('productAll', $productAll['productAll'])->with('companyAll', $companyAll['companyAll'])->with('slide_img', $slide_img)->with('category', $category->getAllCategoris())->with('vip_category', $vip_category);
    }
}