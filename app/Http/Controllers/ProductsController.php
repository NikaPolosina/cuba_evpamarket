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

class ProductsController extends Controller{
    public $paginCnt = 5;

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

    /*  public function createByCategory(Request $request){
          $companyId = $request['companyId'];
          $categoryId = $request['categoryId'];
      }*/
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
        return redirect('company/' . $company->id);
    }

    public function storeCategory(Request $request){

        $newProduct = new Product([
            'product_name'        => $request['product']['name'],
            'product_description' => $request['product']['description'],
            'content'                => $request['product']['content'],
            'product_image'       => $request['product']['photo'],
            'product_price'       => $request['product']['price'],
            'category_id'         => $request['product']['category_name'],
        ]);

        $companyId = $request['company_id'];
        $company = Company::find($companyId);
        $company->getProducts()->save($newProduct);
        if($newProduct->id){
            return view('product.products.singleProductTr')->with([ 'item' => $newProduct ]);
        }
        return response()->json([ 'success' => false ]);
    }

    public function show($id){
        $product = Product::findOrFail($id);
        return view('product.products.show', compact('product'));
    }

    public function edit(Request $request, $id){
        $product = Product::findOrFail($id);
        return view('product.products.edit', compact('product'));
    }

    public function editCategory(Request $request){
        $id = $request->input('productId');
        $product = Product::find($id)->toArray();
        $productCategory = Product::find($id)->getCategory;

        return response()->json([ 'product'         => $product, 'productCategory' => $productCategory]);
    }

    public function update($id, Request $request){
        $this->validate($request, [ 'product_description' => 'required', ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());
        Session::flash('flash_message', 'Product updated!');
        $company = Company::find($request->input('company_id'));
        return redirect('company/' . $company->id);
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
                if($value->id == $companyId)
                    return true;
            }
        }
        return false;
    }

    public function findProduct(Request $request){
        if($request->input('find')){
            $time = time();
            $res = Product::search($request->input('find'))->get();
            return view('welcome')->with([ 'data'   => $res,
                                           'time'   => $time,
                                           'search' => $request->input('find')
                ]);
        }
        return view('welcome');
    }

    public function getProductAll(Request $request){
        $productAll = Product::all();
        $companyAll = Company::all();
        return view('welcome')->with([ 'productAll' => $productAll ])->with([ 'companyAll' => $companyAll ]);
    }

    public function singleProduct(Request $request, $id){
        $singleProduct = Product::find($id)->toArray();
        return view('product.products.singleProductInfo')->with('singleProduct', $singleProduct);
    }

    public function productEditor(CategoryController $category, $id){


        $currentCompanyCategories = $category->getCompanyCategorySorted($id);
        $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);

        $company = Company::find($id);
        return view('product.products.productsEditor')->with([ 'category'   => json_encode($currentCompanyCategoriesSorted),
                                                               'company'    => $company,
                                                               'myCategories'    => $currentCompanyCategories,
                                                               'paginCnt'   => $this->paginCnt,
                                                               'categories' => json_encode($category->getAllCategoris())
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
        if($request->input('id')){
            $product = Product::findOrFail($request->input('id'));
            $result = $product->update(array(
                'product_name'        => $data['name'],
                'product_description' => $data['description'],
                'content'               => $data['content'],
                'product_image'       => $data['photo'],
                'product_price'       => $data['price'],
                'category_id'       => $data['category_name'],
            ));
            if($result){
                return view('product.products.singleProductTr')->with([ 'item' => $product ]);
            }
            return '';
        }
    }
        public function attachCategoryToCompany(Request $request){
            $companyId = Company::find($request['companyId']);

            if (!empty($request['categories'])){
                foreach($request['categories'] as $value){
                    if(! $companyId->getCategoryCompany->contains($value))
                        $companyId->getCategoryCompany()->attach($value);
                }
            }
            return response()->json([ 'companyId' => $companyId, 'category'  => $request['categories']]);

        }

}















