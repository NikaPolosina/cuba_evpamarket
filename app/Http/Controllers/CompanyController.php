<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\UserCompany;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\ProductsController;
use App\User;
use PhpParser\Builder;
use App\Models\Role;
use App\Region;



class CompanyController extends Controller
{

    public $category = array();
    public $nCategory = array();

    public function index(){
        $company = Company::paginate(15);
        return view('company.index', compact('company'));
    }

    public function create(){
        $region = Region::all();
        return view('company.create')->with('region', $region);
    }

    public function store(Request $request){


        $company = Company::create([
            'company_name'       => $request['company_name'],
            'company_description'    => $request['company_description'],
            'company_logo' => $request['company_logo'],
            'company_content'     => $request['company_content'],
            'company_contact_info'     => $request['company_contact_info'],
            'region_id'  => $request->input('region'),
            'city_id'    => $request->input('city'),
            'street'     => $request->input('street'),
            'address'    => $request->input('address'),
            'country'    => 'Росcия',
        ]);

        $company->save();
        if($company){
            $curentUser = Auth::user();
            if($curentUser->hasRole('simple_user')){
                $curentUser->detachRoles($curentUser->roles);
                $curentUser->attachRole(Role::findOrFail(1));
            }

            $curentUser->getCompanies()->save($company);
        }

        //Session::flash('flash_message', 'Company added!');
        return redirect()->intended('home');

    }

    public function createCompany(array $company){
        return Company::create($company);
    }

    public function revers($currentArray){

        foreach ($currentArray as $value) {

            if(array_key_exists($value['id'], $this->nCategory)){
                array_push($value['child'], $this->nCategory[$value['id']]);
            }


            dd($value);

            die('Surprise, you are here !!!');

        }

        die('Surprise, you are here !!!');


    }

    public function show($id, CategoryController $category){

        $company = Company::findOrFail($id);
        if(file_exists(public_path().'/img/custom/companies/'. $company->company_logo) && !empty($company->company_logo)){
            $img = '/img/custom/companies/'. $company->company_logo;
        }else{
            $img = '/img/custom/files/thumbnail/plase.jpg';
        }
        $res = $company->getProducts;
        $productAll = IndexController::showProduct($res);


        return view('company.show')
            ->with('company',  $company)
            ->with('img',  $img)
            ->with('category', $category->getAllCategoris())
            ->with('productAll',  $productAll);

    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);

        $region = Region::all();


        return view('company.edit', compact('company'))->with('region', $region);
    }

    public function update($id, Request $request)
    {




        $this->validate($request, ['company_name' => 'required', 'company_description' => 'required', ]);
        $company = Company::findOrFail($id);
        $updateCompany =  [
            'company_name'       => $request['company_name'],
            'company_description'    => $request['company_description'],
            'company_logo' => $request['company_logo'],
            'company_content'     => $request['company_content'],
            'company_contact_info'     => $request['company_contact_info'],
            'region_id'  => $request->input('region'),
            'city_id'    => $request->input('city'),
            'street'     => $request->input('street'),
            'address'    => $request->input('address'),
            'country'    => 'Росcия',
        ];
        $company->update($updateCompany);

        Session::flash('flash_message', 'Company updated!');
        return redirect()->intended('home');

    }

    public function destroy($id)
    {
        Company::destroy($id);
        Session::flash('flash_message', 'Company deleted!');

        return redirect()->intended('home');

    }

    public function attachUser($user, $company){
        return DB::table('user_company')->insert(
            array('user_id' => $user->id, 'company_id' => $company->id)
        );
    }

    public function getCompanyAll(){
        $companyAll = Company::all();
        return ([
            'companyAll' => $companyAll
        ]);
    }





}
