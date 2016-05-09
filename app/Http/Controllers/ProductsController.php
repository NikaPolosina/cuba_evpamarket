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
    public function __construct(){



    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        $products = Product::paginate(3);
        return view('product.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
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

        $company = Company::find($request['id']);
        $company->getProducts()->save($newProduct);
        if($newProduct->id){


            return view('product.products.singleProductTr')->with(['item' => $newProduct]);

        }
        return response()->json(['success' => false]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id){
        $product = Product::findOrFail($id);
        return view('product.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit(Request $request, $id){
        $product = Product::findOrFail($id);
        return view('product.products.edit', compact('product'));
    }
    public function editCategory(Request $request){
        $id = $request->input('productId');
        $product = Product::find($id)->toArray();
        return response()->json($product);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request){

        $this->validate($request, ['product_description' => 'required',]);
        $product = Product::findOrFail($id);
        $product->update($request->all());
        Session::flash('flash_message', 'Product updated!');

        $company = Company::find($request->input('company_id'));

        return redirect('company/'.$company->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
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
    /**
     * check if user attach to company
     *
     *
     * */
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

        return view('product.products.productsEditor')->with(['category' => json_encode($this->nCategory[0]), 'company'=>$company]);
    }

    public function getProductList(Request $request){

        $companyId = $request->input('companyId');
        $categoriId = $request->input('categoryId');

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

        
        $company = Company::find($companyId);


        $products = $company->getProducts()->whereIn('category_id', $categoriId)->paginate(5);



        if(count($products)){
            return view('product.products.productEditoList')->with('products', $products)->with('category', $this->nCategory)->with('company', $companyId);

        }
            return '';
    }
    
    public function productAjaxUpdate(Request $request){

        $data = $request->all();
        if($request->input('id')){
            //dd($request->all());

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















