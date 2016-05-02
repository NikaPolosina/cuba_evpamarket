<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;


class ProductsController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        $products = Product::paginate(15);
        return view('product.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        if($request->route('company_id') && self::hasCompany($request->route('company_id')) ){
            $company = Company::find($request->route('company_id'));
            return view('product.products.create')->with('company', $company);


        }
        return redirect()->intended('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request){
        $this->validate($request, ['product_description' => 'required', ]);
        $newProduct = new Product([
            'product_id'          => $request->input('product_id'),
            'product_description' => $request->input('product_description'),
            'product_image'       => $request->input('product_image'),
            'product_price'       => $request->input('product_price'),
        ]);

        $company = Company::find($request->input('company_id'));
        $company->getProducts()->save($newProduct);
        Session::flash('flash_message', 'Product added!');

        return redirect('company/'.$company->id);

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

        $company = Company::find($request->input('company_id')); //hskfheshg

        return redirect('company/'.$company->id);//isufisugsnu
      //  return redirect('products');// сюда
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
}
