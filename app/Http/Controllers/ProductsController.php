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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\CartController;

class ProductsController extends Controller{

    public $paginCnt = 5;

    public function __construct(Request $request){
        
        view()->share('product_cnt', CartController::getProductCount($request));
    }

    public function index(){
        $products = Product::paginate($this->paginCnt);
        return view('product.products.index', compact('products'));
    }

    public function create(Request $request, CategoryController $category){
        if($request->route('company_id') && self::hasCompany($request->route('company_id'))){
            $company = Company::find($request->route('company_id'));
            return view('product.products.create')->with('company', $company)->with([ 'category' => json_encode($category->getAllCategoris()) ]);
        }
        return redirect()->intended('home');
    }

    public function store(Request $request){
        $this->validate($request, [ 'product_description' => 'required', ]);

        $newProduct = new Product([
            'product_name'        => $request->input('product_name'),
            'product_description' => $request->input('product_description'),
            'product_image'       => $request->input('product_image'),
            'product_price'       => $request->input('product_price'),
            'category_id'         => $request->input('product_category'),
        ]);
        $company = Company::find($request->input('company_id'));
        $company->getProducts()->save($newProduct);
        Session::flash('flash_message', 'Product added!');
        return redirect('company/'.$company->id);
    }

    public static function cropFile($file, $newPath, $name){
        $size = getimagesize($file);
        $width = $size[0];
        $height = $size[1];
        $type = $size[2];

        if($type == 1){
            $image = imagecreatefromgif($file);
        }elseif($type == 2){
            $image = imagecreatefromjpeg($file);
        }elseif($type == 3){
            $image = imagecreatefrompng($file);
        }else{
            $image = imagecreatefromwbmp($file);
        }

        If($width / $height > 1){
            $a = $width - $height;
            $new_img = imagecreatetruecolor($height, $height);
            imagecopyresampled($new_img, $image, 0, 0, $a / 2, 0, $height + $a, $height, $width, $height);
        }else{
            $a = $height - $width;
            $new_img = imagecreatetruecolor($width, $width);
            imagecopyresampled($new_img, $image, 0, 0, 0, $a / 2, $width, $width + $a, $width, $height);
        }

        if($type == 1){
            if(imagegif($new_img, public_path().$newPath.$name.'.gif')){
                imagegif($new_img, public_path().$newPath.'thumbnail/'.$name.'.gif');
                return true;
            }
            return false;
        }elseif($type == 2){
            if(imagejpeg($new_img, public_path().$newPath.$name.'.jpg')){
                imagejpeg($new_img, public_path().$newPath.'thumbnail/'.$name.'.jpg');
                return true;
            }
            return false;
        }elseif($type == 3){
            if(imagepng($new_img, public_path().$newPath.$name.'.png')){
                imagepng($new_img, public_path().$newPath.'thumbnail/'.$name.'.png');
                return true;
            }
            return false;
        }else{
            if(imagewbmp($new_img, public_path().$newPath.$name.'.bmp')){
                imagewbmp($new_img, public_path().$newPath.'thumbnail/'.$name.'.bmp');
                return true;
            }
            return false;
        }
    }

    public function storeCategory(Request $request){

        $newProduct = new Product([
            'product_name'        => $request['product']['name'],
            'product_description' => $request['product']['description'],
            'content'             => $request['product']['content'],
            'product_image'       => $request['product']['photo'],
            'product_price'       => $request['product']['price'],
            'category_id'         => $request['product']['category_name'],
        ]);

        $companyId = $request['company_id'];
        $company = Company::find($companyId);
        $company->getProducts()->save($newProduct);
        if($newProduct->id){

            if($request->input('product')['filesPath']){
                $originPath = public_path().'/img/custom/'.$request->input('product')['filesPath'];
                $newPath = public_path().'/img/custom/companies/'.$company->id.'/products/'.$newProduct->id.'/';
                File::copyDirectory($originPath, $newPath);
                File::deleteDirectory($originPath);
            }

            return view('product.products.singleProductTr')->with([ 'item' => $newProduct ]);
        }
        return response()->json([ 'success' => false ]);
    }

    public function show(Request $request){
        $product = Product::findOrFail($request['id']);
        $id = $product->getCompany['0']['id'];

        $directory = public_path().'/img/custom/companies/'.$id.'/products/'.$request['id'];

        if(!empty($product->product_image) && File::exists($directory.'/'.$product->product_image)){
            $firstFile = '/img/custom/companies/'.$id.'/products/'.$request['id'].'/thumbnail/'.$product->product_image;
        }else{
            $directoryMy = '/img/custom/companies/'.$id.'/products/'.$request['id'].'/';

            if(is_dir($directory)){
                $files = scandir($directory);
                $firstFile = $directoryMy.$files[2];// because [0] = "." [1] = ".."

                if(is_dir(public_path().$firstFile)){
                    if(isset($files[3])){
                        $firstFile = $directoryMy.$files[3];
                    }else{
                        $firstFile = '/img/custom/files/thumbnail/plase.jpg';
                    }
                }
            }else{
                $firstFile = '/img/custom/files/thumbnail/plase.jpg';
            }
        }

        return response()->json([
            'product'  => $product,
            'img'      => $firstFile,
            'mainPath' => 'companies/'.$id.'/products/'.$request['id'].'/',
        ]);
    }

    public function edit(Request $request, $id){
        $product = Product::findOrFail($id);
        return view('product.products.edit', compact('product'));
    }

    public function editCategory(Request $request){

        $id = $request->input('productId');
        $product = Product::find($id)->toArray();
        $productCategory = Product::find($id)->getCategory;

        if(!strlen($product['product_image'])){
            $product['product_image'] = json_encode([ '' ]);
        }

        return response()->json([
            'product'         => $product,
            'productCategory' => $productCategory
        ]);
    }

    public function update($id, Request $request){
        $this->validate($request, [ 'product_description' => 'required', ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());
        Session::flash('flash_message', 'Product updated!');
        $company = Company::find($request->input('company_id'));
        return redirect('company/'.$company->id);
    }

    public function destroy(Request $request){
        Product::destroy($request['id']);
        Session::flash('flash_message', 'Product deleted!');
    }

    public function destroyCheck(Request $request){
        foreach($request['checkId'] as $value){
            Product::destroy($value);
        }
        Session::flash('flash_message', 'Product deleted all!');
    }

    public static function hasCompany($companyId){
        if(Auth::check() && count(Auth::user()->getCompanies)){
            foreach(Auth::user()->getCompanies as $value){
                if($value->id == $companyId){
                    return true;
                }
            }
        }
        return false;
    }

    public function findProduct(Request $request, Company $company){

        if($request->input('find')){
            $res = Product::search($request->input('find'))->get();
            $productAll = IndexController::showProduct($res);

            return view('find')->with('productAll', $productAll)->with('search', $request->input('find'));
        }

        return view('welcome');
    }

    public function getProductAll(){
        $productAll = Product::all();
        return ([
            'productAll' => $productAll
        ]);
    }

    public function singleProduct(Request $request, $id){

        $singleProduct = Product::find($id)->toArray();
        $companyId = Product::find($id)->getCompany[0]['id'];

        return view('product.products.singleProductInfo')->with('singleProduct', $singleProduct)->with('companyId', $companyId);
    }

    public function productEditor(CategoryController $category, $id){

        $currentCompanyCategories = $category->getCompanyCategorySorted($id);
        $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);

        $company = Company::find($id);
        return view('product.products.productsEditor')->with([
            'category'     => json_encode($currentCompanyCategoriesSorted),
            'company'      => $company,
            'myCategories' => $currentCompanyCategories,
            'paginCnt'     => $this->paginCnt,
            'categories'   => json_encode($category->getAllCategoris())
        ]);
    }

    public function getProductList(Request $request, CategoryController $category){

        $companyId = $request->input('companyId');
        $categoriId = $request->input('categoryId');
        $company = Company::find($companyId);
        if($categoriId){
            $this->nCategory = $category->getCompanyActiveCategory($categoriId);
            $products = $company->getProducts()->whereIn('category_id', $categoriId)->paginate($this->paginCnt);
        }else{
            $this->nCategory = NULL;
            $products = $company->getProducts()->paginate($this->paginCnt);
        }

        if(count($products)){
            return view('product.products.productEditorList')->with('products', $products)->with('category', $this->nCategory);
        }
        /* return '';*/
        return view('product.products.productEditorList')->with('products', $products)->with('category', $this->nCategory);
    }

    public function productAjaxUpdate(Request $request){
        $data = $request->all();
        if($request->input('product')['product_id']){
            $product = Product::findOrFail($request->input('product')['product_id']);

            $result = $product->update(array(
                'product_name'        => $request->input('product')['name'],
                'product_description' => $request->input('product')['description'],
                'content'             => $request->input('product')['content'],
                'product_image'       => $request->input('product')['photo'],
                'product_price'       => $request->input('product')['price'],
                'category_id'         => $request->input('product')['category_name'],
            ));
            if($result){
                return view('product.products.singleProductTr')->with([ 'item' => $product ]);
            }
            return '';
        }
    }

    public function attachCategoryToCompany(Request $request){
        $companyId = Company::find($request['companyId']);

        if(!empty($request['categories'])){
            foreach($request['categories'] as $value){
                if(!$companyId->getCategoryCompany->contains($value)){
                    $companyId->getCategoryCompany()->attach($value);
                }
            }
        }
        return response()->json([
            'companyId' => $companyId,
            'category'  => $request['categories']
        ]);
    }

}




