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


class ProductsController extends Controller{

    public $paginCnt = 5;

    public function index(){

        $products = Product::paginate($this->paginCnt);
        return view('product.products.index', compact('products'));
    }
    public function create(Request $request){

        if($request->route('company_id') && self::hasCompany($request->route('company_id')) ){
            $company = Company::find($request->route('company_id'));

            $this->category = Category::all()->toArray();

            foreach ($this->category as $value) {
                $value['text'] = $value['title'];
                $value['href'] = $value['id'];
                $value['nodes'] = array();
                $this->nCategory[$value['parent_id']][] = $value;
            }
            ksort($this->nCategory);
            $this->nCategory = array_reverse($this->nCategory, true);

            foreach ($this->nCategory as $key => $value) {
                foreach ($value as $k => $v) {
                    if(array_key_exists($v['id'], $this->nCategory)){
                        $this->nCategory[$key][$k]['nodes'] = $this->nCategory[$v['id']];
                        unset($this->nCategory[$v['id']]);
                    }
                }
            }

            return view('product.products.create')->with('company', $company)->with(['category' => json_encode($this->nCategory[0])]);


        }
        return redirect()->intended('home');
    }
    public function createByCategory(Request $request){
        $companyId = $request['companyId'];
        $categoryId = $request['categoryId'];


    }
    public function store(Request $request){

        $this->validate($request, ['product_description' => 'required', ]);
        $newProduct = new Product([
            'product_name'          => $request->input('product_name'),
            'product_description' => $request->input('product_description'),
            'product_image'       => $request->input('product_image'),
            'product_price'       => $request->input('product_price'),
            'category_id'       => $request->input('product_category'),
        ]);
        $company = Company::find($request->input('company_id'));
        $company->getProducts()->save($newProduct);
        Session::flash('flash_message', 'Product added!');
        return redirect('company/'.$company->id);
    }
    public function storeCategory(Request $request){



        $newProduct = new Product([
            'product_name'        => $request['checkId']['name'],
            'product_description' => $request['checkId']['description'],
            'product_image'       => $request['checkId']['photo'],
            'product_price'       => $request['checkId']['price'],
            'category_id'         => $request['checkId']['category_id'],
        ]);

        $idJson= $request['id'];
        $idNoJson = json_decode($idJson, true);
        $company = Company::find($idNoJson['id']);



        $company->getProducts()->save($newProduct);
        if($newProduct->id){
            return view('product.products.singleProductTr')->with(['item' => $newProduct]);
        }
        return response()->json(['success' => false]);


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

        return response()->json(['product' => $product, 'productCategory' => $productCategory]);
        
    }
    public function update($id, Request $request){

        $this->validate($request, ['product_description' => 'required',]);
        $product = Product::findOrFail($id);
        $product->update($request->all());
        Session::flash('flash_message', 'Product updated!');

        $company = Company::find($request->input('company_id'));

        return redirect('company/'.$company->id);
    }
    public function destroy(Request $request, $id){
        $company = Product::find($id)->getCompany;
        Product::destroy($id);
        Session::flash('flash_message', 'Product deleted!');
        return redirect('company/'.$company[0]->id);//isufisugsnu
     //   return redirect('products');
    }
    public function destroyCheck(Request $request){



            foreach($request['checkId'] as $value){
                Product::destroy($value);
            }
            Session::flash('flash_message', 'Product deleted all!');




        }

    public static function hasCompany($companyId){
        if(Auth::check() && count(Auth::user()->getCompanies)){
            foreach (Auth::user()->getCompanies as $value) {
                if($value->id == $companyId) return true;
            }
        }
        return false;
    }

    public  function findProduct(Request $request){

        if($request->input('find')){
            $time = time();
            $res = Product::search($request->input('find'))->get();
            return view('welcome')->with(['data'=>$res, 'time'=>$time, 'search'=>$request->input('find')]);

        }

        return view('welcome');

    }
    public function getProductAll(Request $request){
        $productAll = Product::all();
        $companyAll = Company::all();
        return view('welcome')->with(['productAll'=>$productAll])->with(['companyAll'=>$companyAll]);
    }
    public function singleProduct(Request $request, $id){

        $singleProduct = Product::find($id)->toArray();
        return view('product.products.singleProductInfo')->with('singleProduct',  $singleProduct);


    }

    public function checkCat($search, $arr){

        foreach ($arr as $value) {
            if($search == $value['id']) return false;
        }
        return true;
    }

    public function productEditor($id){
        $company = Company::findOrFail($id);
        $this->category = array();
            foreach ($company->getProducts as $value) {
                $parentId = $value->getCategory->toArray()['parent_id'];
                if(!$this->checkCat($value->getCategory->toArray()['id'], $this->category))
                    continue;
                $this->category[] = $value->getCategory->toArray();

                do{
                    $current = Category::find($parentId)->toArray();
                    $parentId = $current['parent_id'];

                    if(!$this->checkCat($current['id'], $this->category))
                        break;
                    $this->category[] = $current;

                }while($parentId != 0);
            }
            foreach ($this->category as $value) {
                $value['text'] = $value['title'];
                $value['href'] = $value['id'];
                $value['nodes'] = array();
                $this->nCategory[$value['parent_id']][] = $value;
            }
            ksort($this->nCategory);
            $this->nCategory = array_reverse($this->nCategory, true);
            foreach ($this->nCategory as $key => $value) {
            foreach ($value as $k => $v) {
                if(array_key_exists($v['id'], $this->nCategory)){
                    $this->nCategory[$key][$k]['nodes'] = $this->nCategory[$v['id']];
                    unset($this->nCategory[$v['id']]);
                }
            }
        }

        return view('product.products.productsEditor')->with(['category' => json_encode($this->nCategory[0]), 'company'=>$company, 'paginCnt'=>$this->paginCnt]);
    }

    public function getProductList(Request $request){

        $companyId = $request->input('companyId');
        $categoriId = $request->input('categoryId');

        $company = Company::find($companyId);

        if($categoriId){
            $this->category[] = Category::find($categoriId[0])->toArray();
            $parentId = $this->category[0]['parent_id'];

            if($parentId != 0){
                do{

                    $current = Category::find($parentId)->toArray();
                    $parentId = $current['parent_id'];

                    $this->category[] = $current;

                }while($parentId != 0);

                foreach ($this->category as $value) {
                    $value['text'] = $value['title'];
                    $value['href'] = $value['id'];
                    $value['nodes'] = array();

                    $this->nCategory[$value['parent_id']][] = $value;
                }
                ksort($this->nCategory);
            }else{
                $this->nCategory[$this->category[0]['parent_id']] = $this->category;
            }

            $products = $company->getProducts()->whereIn('category_id', $categoriId)->paginate($this->paginCnt);
        }else{
            $this->nCategory = null;
            $products = $company->getProducts()->paginate($this->paginCnt);
        }

        if(count($products)){
            return view('product.products.productEditorList')->with('products', $products)->with('category', $this->nCategory);
        }
        return '';
    }
    
    public function productAjaxUpdate(Request $request){
        $data = $request->all();

        if($request->input('id')){

            $product = Product::findOrFail($request->input('id'));

            $result = $product->update(array(
                'product_name'=>$data['name'],
                'product_description'=>$data['description'],
                'product_image'=>$data['photo'],
                'product_price'=>$data['price'],
                ));

            if($result){
                return view('product.products.singleProductTr')->with(['item' => $product]);
            }
            return '';
        }

    }

}















