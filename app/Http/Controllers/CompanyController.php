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



class CompanyController extends Controller
{

    public $category = array();
    public $nCategory = array();

    public function index(){
        $company = Company::paginate(15);
        return view('company.index', compact('company'));
    }
    
    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $company =  $this->createCompany($request->except('_token'));
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
//        $this->validate($request->input('company'), ['company_name' => 'required', 'company_description' => 'required', ]);
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

    public function show($id){




        $company = Company::findOrFail($id);

       /* $this->category = Category::all()->toArray();

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
        }*/


        //return view('company.show')->with(['category' => json_encode($this->nCategory[0]), 'company'=>$company]);
        return view('company.show')->with('company',  $company);

    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);

        return view('company.edit', compact('company'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, ['company_name' => 'required', 'company_description' => 'required', ]);
        $company = Company::findOrFail($id);
        $company->update($request->all());

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
