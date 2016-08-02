<?php
namespace App\Http\Controllers;

use App\Category;
use App\DiscountAccumulativ;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use App\Product;
use App\StatusOwner;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Exception;
use Session;
use App\Models\UserCompany;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\ProductsController;
use App\User;
use PhpParser\Builder;
use App\Models\Role;
use App\Region;

class CompanyController extends Controller{
    public $category  = array();
    public $nCategory = array();

    public function create(){
        $region = Region::all();
        return view('company.create')->with('region', $region);
    }

    public function store(Request $request){
        $company = Company::create([
            'company_name'         => $request['company_name'],
            'company_description'  => $request['company_description'],
            'company_logo'         => $request['company_logo'],
            /* 'company_content'     => $request['company_content'],*/
            'company_contact_info' => $request['company_contact_info'],
            'region_id'            => $request->input('region'),
            'city_id'              => $request->input('city'),
            'street'               => $request->input('street'),
            'address'              => $request->input('address'),
            'country'              => 'Росcия',
        ]);
        $company->save();
        if($company){
            $curentUser = Auth::user();
            $curentUser->getCompanies()->save($company);
        }


        return view('company.companyContent')->with('company_id', $company['id']);
        // return redirect()->intended('homeOwnerUser');
    }

    public function companyContent(Request $request){
        $id = $request['company_id'];
        $company = Company::find($id);
        $company_content = [
            'company_content' => $request['company_content']
        ];
        $company->update($company_content);
        return redirect()->intended('homeOwnerUser');
    }

    public function createCompany(array $company){
        return Company::create($company);
    }

    public function revers($currentArray){
        foreach($currentArray as $value){
            if(array_key_exists($value['id'], $this->nCategory)){
                array_push($value['child'], $this->nCategory[$value['id']]);
            }
            dd($value);
            die('Surprise, you are here 5!!!');
        }
        die('Surprise, you are here 7!!!');
    }

    public function show($id, CategoryController $category){
        $company = Company::findOrFail($id);
        if(file_exists(public_path() . '/img/custom/companies/' . $company->company_logo) && !empty($company->company_logo)){
            $img = '/img/custom/companies/' . $company->company_logo;
        }else{
            $img = '/img/custom/files/thumbnail/plase.jpg';
        }
        $res = $company->getProducts;
        $productAll = IndexController::showProduct($res);
        return view('company.show')->with('company', $company)->with('img', $img)->with('category', $category->getAllCategoris())->with('productAll', $productAll);
    }

    public function edit($id){
        $company = Company::findOrFail($id);
        $region = Region::all();
        return view('company.edit', compact('company'))->with('region', $region);
    }

    public function update($id, Request $request){
        $this->validate($request, [
            'company_name'        => 'required',
            'company_description' => 'required',
        ]);
        $company = Company::findOrFail($id);
        $updateCompany = [
            'company_name'         => $request['company_name'],
            'company_description'  => $request['company_description'],
            'company_logo'         => $request['company_logo'],
            'company_content'      => $request['company_content'],
            'company_contact_info' => $request['company_contact_info'],
            'region_id'            => $request->input('region'),
            'city_id'              => $request->input('city'),
            'street'               => $request->input('street'),
            'address'              => $request->input('address'),
            'country'              => 'Росcия',
        ];
        $company->update($updateCompany);
        Session::flash('flash_message', 'Company updated!');
        return redirect()->intended('homeOwnerUser');
    }

    public function destroy($id){

        $company = Company::find($id);
        if(count($company->getProducts) > 0){
            Product::destroy($company->getProducts->lists('id'));
        }

        Company::destroy($id);

        Session::flash('flash_message', 'Company deleted!');
        return redirect()->intended('homeOwnerUser');
    }

    public function attachUser($user, $company){
        return DB::table('user_company')->insert(array(
            'user_id'    => $user->id,
            'company_id' => $company->id
        ));
    }

    public function getCompanyAll(){
        $companyAll = Company::all();
        return ([
            'companyAll' => $companyAll
        ]);
    }

    public function getMyShop(Request $request){
        $curentUser = Auth::user();
        $companys = $curentUser->getCompanies()->with([
            'getOrder' => function ($query){
                $query->where('status', StatusOwner::where('key', 'not_processed')->first([ 'id' ])->id);
            }
        ])->get();
        return view('company.myShop')->with('companys', $companys);
    }

    public function setupDiscount($id){
        $company = Company::find($id);
        $discount = $company->getDiscountAccumulativ;
        return view('company.setupDiscount')->with('discount', $discount)->with('company', $company);
    }

    public function createDiscount($id, Request $request){

         $this->validate($request, [
            'from'=> 'required|integer|min:0|max:'.$request->to ,
            'to' => 'required|integer|min:'.$request->from,
            'percent' => 'required|integer|min:1|max:99'
        ]);



        if(empty($request['id'])){
            $newDiscount = DiscountAccumulativ::create([
                'from'       => $request['from'],
                'to'         => $request['to'],
                'percent'    => $request['percent'],
                'company_id' => $id
            ]);
            $newDiscount->save();
            if($newDiscount){
                $company = Company::find($id);
                $company->getDiscountAccumulativ()->save($newDiscount);
            }
        }else{
            $discount = [
                'from'    => $request['from'],
                'to'      => $request['to'],
                'percent' => $request['percent'],
            ];
            $discount_single = DiscountAccumulativ::findOrFail($request['id']);
            $discount_single->update($discount);
        }
        return redirect()->intended('company-discount-setup/' . $id);
    }

    public function destroyDiscount($company_id, $discount_id){
        $company = Auth::user()->getCompanies()->where('id', $company_id)->first();
        $company->getDiscountAccumulativ()->where('id', $discount_id)->first()->delete();
        return redirect()->back();
    }
}
