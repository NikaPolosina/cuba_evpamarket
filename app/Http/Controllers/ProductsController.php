<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\StatusOwner;
use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use Mockery\Exception;
use Session;
use App\Company;
use Auth;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Validator;
use Creitive\Breadcrumbs\Breadcrumbs;

class ProductsController extends Controller{

    public $paginCnt = 5;
    private $_product;
    protected $_breadcrumbs;
    protected $_user;

    public function __construct(Request $request,  Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider('<img style="display: inline-block;  height: 37px;" src="/img/system/next-bread.png">');
    }

    public function destroyProductDir($id){
        $company = Product::find($id)->getCompany;
        $dir = public_path().'/img/custom/companies/'.$company[0]['id'].'/products/'.$id;
        if(is_dir($dir)){
            File::deleteDirectory($dir);
        }
    }

    public function index(){
        $products = Product::paginate($this->paginCnt);
        return view('product.index', compact('products'));
    }

    public function create(Request $request, CategoryController $category){
        if($request->route('company_id') && self::hasCompany($request->route('company_id'))){
            $company = Company::find($request->route('company_id'));
            return view('product.create')->with('company', $company)->with([ 'category' => json_encode($category->getAllCategoris()) ]);
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


        //dd($request->all());
        $validator = Validator::make(
            $request->input('product'),
            array(
                'name' => 'required|max:255|min:2',
                'description' => 'required|min:2',
                'price' => 'required|integer|min:1'
            )
        );
        $validator->setAttributeNames([
            'name'=> 'Имя товара',
            'description'=> 'Описание',
            'price'=> 'Цена',
        ]);
        if($validator->fails()){

            return response()->json([
                'error'  => $validator->errors() ], 200);
        }
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

            return view('product.singleProductTr')->with([ 'item' => $newProduct ])->with(['x'=>$request->x+1]);;
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
        return view('product.edit', compact('product'));
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
        $this->destroyProductDir($request['id']);
        Product::destroy($request['id']);
        Session::flash('flash_message', 'Product deleted!');
    }

    public function destroyCheck(Request $request){
        foreach($request['checkId'] as $value){
            $this->destroyProductDir($value);
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

    public function getProductAll(){
        $productAll = Product::all();
        return ([
            'productAll' => $productAll
        ]);
    }

    static function preparationFile($id){
        $singleProduct = Product::find($id)->toArray();
        $companyId = Product::find($id)->getCompany[0]['id'];
        $idProduct = $singleProduct['id'];
        $directory = public_path().'/img/custom/companies/'.$companyId.'/products/'.$idProduct;
        $directoryMy = '/img/custom/companies/'.$companyId.'/products/'.$idProduct.'/';
        if(is_dir($directory)){
            $allFile = array_diff(scandir($directory), array('.', '..'));
            $singleFile = array();
            foreach($allFile as $value){
                if(file_exists($directory.'/'.$value) && !is_dir($directory.'/'.$value)){
                    $singleFile[] = $directoryMy.$value;
                }
            }
        }else{
            $singleFile[] = '/img/custom/files/thumbnail/plase.jpg';
        }
        if(!empty($singleProduct['product_image']) && File::exists($directory.'/'.$singleProduct['product_image'])){

            $firstFile = $directoryMy.$singleProduct['product_image'];
        }else{
            if(is_dir($directory)){
                $files = scandir($directory);
                $firstFile = $directoryMy.$files[2];// because [0] = "." [1] = ".."

                if(is_dir(public_path().$firstFile)){
                    if(isset($files[3]))
                        $firstFile = $directoryMy.$files[3];
                    else
                        $firstFile = '/img/custom/files/thumbnail/plase.jpg';
                }
            }else{
                $firstFile = '/img/custom/files/thumbnail/plase.jpg';
            }
        }

        $file['singleFile'] = $singleFile;
        $file['firstFile'] = $firstFile;
        $file['companyId'] = $companyId;
        $file['singleProduct'] = $singleProduct;
        return $file;
    }

    static function preparationRating($id){

        $product = Product::where('id', $id)->with([
            'getFeedback' => function($query){
                $query->with(['getUser' => function($query){
                    $query->with('getUserInformation');
                }])->with('getAdditionFeed');
            }
        ])->first();

        $product->raiting = 0;
        $product->count = $product->getFeedback->count();

        if($product->count){
            $product->raiting = (($product->getFeedback()->sum('rating') / $product->count) * 100) / 5;
        }
        return $product;
    }

    public function way(CategoryController $category, $wey, $id){

        $file = self::preparationFile($id);
        $product = self::preparationRating($file['singleProduct']['id']);

      // dd($product->getCompany[0]->getUser[0]->getUserInformation->name);


        return view('product'.$wey)
            ->with('singleProduct', $product)
            ->with('firstFile', $file['firstFile'])
            ->with('singleFile', $file['singleFile'])
            ->with('category', $category->getAllCategoris())
            ->with('companyId', $file['companyId']);
    }

    public function singleProduct(CategoryController $category, $id){

        return $this->way($category, '.singleProductInfo', $id);
    }

    public function singleProductMyShop(CategoryController $category, $id){

        $companyId = Product::find($id)->getCompany[0]['id'];
        $company = Company::find($companyId);
        $product = Product::find($id);
       
        $currentCompanyCategories = $category->getCompanyCategorySorted($companyId);
        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Магазин - '.$company->company_name, '/product-editor/'.$companyId);
        $this->_breadcrumbs->addCrumb($product->product_name, '/single-product-my-shop/'.$id);


        return $this->way($category, '.singleProductMyShop', $id)->with('myCategories', $currentCompanyCategories) ->with('breadcrumbs', $this->_breadcrumbs);
    }

    public function productEditor(CategoryController $category, $id){

        $currentCompanyCategories = $category->getCompanyCategorySorted($id);
        $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);
        $company = Company::find($id);

        $company->perDayAmount = OrderController::getAmount($company->id, 0);
        $company->perWeekAmount = OrderController::getAmount($company->id, 7);
        $company->totalAmount = OrderController::getAmount($company->id, 365);
        
        $order  = $company->getOrder()->get();
        foreach($order as $item){
            $item->getStatusOwner->where('key', 'not_processed')->get();
        }

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Магазин - '.$company->company_name, '/product-editor/'.$company->id);

        return view('product.productsEditor')->with([
            'category'     => json_encode($currentCompanyCategoriesSorted),
            'company'      => $company,
            'myCategories' => $currentCompanyCategories,
            'paginCnt'     => $this->paginCnt,
            'categories'   => json_encode($category->getAllCategoris())
        ])
            ->with('breadcrumbs', $this->_breadcrumbs);
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

        $company->perDayAmount = OrderController::getAmount($companyId, 0);
        $company->perWeekAmount = OrderController::getAmount($companyId, 7);
        $company->totalAmount = OrderController::getAmount($companyId, 365);



        return view('product.productListBody')->with('products', $products)
            ->with( 'company' , $company)
            ->with('category', $this->nCategory);
    }

    public function productAjaxUpdate(Request $request){
        $validator = Validator::make($request->input('product'), array(
                'name'        => 'required|max:255|min:2',
                'description' => 'required|min:2',
                'price'       => 'required|integer|min:1'
            ));
        $validator->setAttributeNames([
            'name'        => 'Имя товара',
            'description' => 'Описание',
            'price'       => 'Цена',
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ], 200);
        }
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
                return view('product.singleProductTr')->with([ 'item' => $product ])->with([ 'x' => $request->x ]);
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

    /**
     * Get single product by ajax
     *
     * @return json
     * */
    public function ajaxSingleProduct(Request $request, CartController $cartController){
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        try{
            $this->_product = self::getSingleProduct($request->input('id'));
            return response()->json([
                'product' => self::getSingleProduct($request->input('id')),
                'cart_cnt'    => $cartController->getTotalProductCnt(),
                'total_in_shop'    => $cartController->getTotalAmount($this->_product->getCompany[0]->id),
            ], 200);
        }catch(\Exception $e){
            return response()->json([ 'error' => $e->getMessage() ], 422);
        }
    }

    /**
     * Get single product
     *
     * @param int $id - product id
     *
     * @return object
     * */
    public static function getSingleProduct($id){
        return IndexController::showProduct(Product::findOrFail($id));
    }

    /**
     * Product form builder
     *
     * @param int $shopId
     * @param int $categoryId
     * @param Request Request
     *
     * @return Response json
     * */
    public function productForm($companyId, $categoryId = null, Request $request, CategoryController $category){
        $validator = Validator::make(
            [
                'companyId'=>$companyId,
                'categoryId'=>$categoryId
            ],
            array(
                'companyId'=>'required|exists:companies,id',
                'categoryId'=>'sometimes|required|exists:category,id'
            )
        );

        if($validator->fails()){
            return response()->json([
                'error'  => $validator->errors() ], 422);
        }

        $this->_user = Auth::user();

        return view('product.form')->with([
            'product', $this->_product,
            'myCategories' => $category->getCompanyCategorySorted($companyId)
        ]);
    }

}




