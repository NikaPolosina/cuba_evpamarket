<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\CompanyController;
use App\Company;
use App\Product;
use App\UserInformation;
use Illuminate\Contracts\Validation;
use App\Models\UserCompany;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class AuthController extends Controller{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectTo = '/home';

    public function __construct(){
//        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
    protected function myValidator(array $data){
        return Validator::make($data, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'date_birth' => 'required',
            'gender' => 'required|boolean',
            'location' => 'required|max:255',
        ]);
    }
    protected function create(array $data){

        $user = User::create([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        $role = Role::findOrFail(2);

        if(isset($data['company'])){
            $role = Role::findOrFail(1);
        }

        $user->attachRole($role);
        return $user;
    }

    public function registerCompany(Request $request, CompanyController $company){

            $user = Auth::user();

            $com = new Company([
                'company_name' => $request->input('company')['company_name'],
                'company_description' => $request->input('company')['company_description'],
                'company_logo' => $request->input('company')['company_logo'],
                'company_content' => $request->input('company')['company_content'],
                'company_address' => $request->input('company')['company_address'],
                'company_contact_info' => $request->input('company')['company_contact_info'],
                'company_additional_info' => $request->input('company')['company_additional_info'],
            ]);


            $user->getCompanies()->save($com);

            return redirect()->intended('home');


    }

    public function registerAditional(Request $request){
        $v = $this->myValidator($request->all());
        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v);
        }

        if(Auth::user()){
           $userinfo =  UserInformation::create([
                'name' => $request->input('name'),
                'surname' => $request->input('surname'),
                'date_birth' => $request->input('date_birth'),
                'gender' => $request->input('gender'),
                'location' => $request->input('location'),
            ]);

            Auth::user()->getUserInformation()->save($userinfo);
            return redirect('home');


        }
    }

    public function registerC(){
        return view('auth.register')->withCompany(true);
    }

}


