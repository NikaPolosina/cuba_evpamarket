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

    public static function showProduct($arr){

        foreach($arr as $v){
            $idProduct = $v['id'];
            $idCompany = $v->getCompany[0]['id'];
            $directory = public_path() . '/img/custom/companies/' . $idCompany . '/products/' . $idProduct;
            $directoryMy = '/img/custom/companies/' . $idCompany . '/products/' . $idProduct . '/';
            if(!empty($v['product_image']) && File::exists($directory . '/' . $v['product_image'])){
                $v->firstFile = $directoryMy . $v['product_image'];
            }else{
                if(is_dir($directory)){

                    $files = scandir($directory);
                    $v->firstFile = $directoryMy . $files[2];
                    if(is_dir(public_path() . $v->firstFile)){
                        if(isset($files[3]))
                            $v->$firstFile = $directoryMy . $files[3];else
                            $v->firstFile = '/img/custom/files/thumbnail/plase.jpg';
                    }
                }else{
                    $v->firstFile = '/img/custom/files/thumbnail/plase.jpg';

                }
            }
        }

        return $arr;
    }


    public function Index(ProductsController $product, CompanyController $company, CategoryController $category){


        $productAll = Product::paginate(8);

        $companyAll = $company->getCompanyAll();

        $dir = 'images/large';
        $vip_category = Category::where('vip', 1)->get();

        $slide_img = array_diff(scandir($dir), array(
            '..',
            '.'
        ));

        $this->showProduct($productAll);



        return view('welcome')
            ->with('productAll', $productAll)
            ->with('companyAll', $companyAll['companyAll'])
            ->with('slide_img', $slide_img)
            ->with('category', $category->getAllCategoris())
            ->with('vip_category', $vip_category);
    }
}