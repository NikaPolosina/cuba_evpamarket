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
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller{

    /**
     * Get products image
     *
     * @param object $arr
     *
     * @return array
     * */
    public static function showProduct($arr){

        if ($arr instanceof Product) {
            $arr = self::getProductImg($arr);
        }else{
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
                                $v->firstFile = $directoryMy . $files[3];else
                                $v->firstFile = '/img/custom/files/thumbnail/plase.jpg';
                        }
                    }else{
                        $v->firstFile = '/img/custom/files/thumbnail/plase.jpg';

                    }
                }
            }
        }

        return $arr;
    }

    /**
     * Get single product image
     * 
     * @param object $v Instance of model class
     *                    
     * @return 
     * */
    private static function getProductImg(Product $product){
        $idProduct = $product['id'];
        $idCompany = $product->getCompany[0]['id'];
        $directory = public_path() . '/img/custom/companies/' . $idCompany . '/products/' . $idProduct;
        $directoryMy = '/img/custom/companies/' . $idCompany . '/products/' . $idProduct . '/';

        if(!empty($product['product_image']) && File::exists($directory . '/' . $product['product_image'])){
            $product->firstFile = $directoryMy . $product['product_image'];
        }else{
            if(is_dir($directory)){

                $files = scandir($directory);
                $product->firstFile = $directoryMy . $files[2];
                if(is_dir(public_path() . $product->firstFile)){
                    if(isset($files[3]))
                        $product->firstFile = $directoryMy . $files[3];else
                        $product->firstFile = '/img/custom/files/thumbnail/plase.jpg';
                }
            }else{
                $product->firstFile = '/img/custom/files/thumbnail/plase.jpg';

            }
        }
        return $product;
    }


    public function Index(ProductsController $product, CompanyController $company, CategoryController $category, Request $request){
        
        $productAll = Product::paginate(8);

        $companyAll = $company->getCompanyAll();

        foreach($companyAll['companyAll'] as $value){

            $value->company_logo = $company->showCompanyLogo($value->id);
        }
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