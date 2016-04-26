<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;

//use Faker\Provider\hu_HU\Company;
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
//use Auth as AuthUser;

class AuthController extends Controller{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    public function __construct(){
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    protected function validator(array $data){
        return Validator::make($data, [

            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'date_birth' => 'required',
            'gender' => 'required|boolean',
            'location' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

    }

    protected function create(array $data){
        $v = $this->validator($data);

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v);
        }

        $user =  User::create([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        if($user){
            Auth::login($user);
           $userinfo =  UserInformation::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'date_birth' => $data['date_birth'],
                'gender' => $data['gender'],
                'location' => $data['location'],
            ]);

            $user->getUserInformation()->save($userinfo);
            return $user;

        }

    }


    public function registerCompany(Request $request, CompanyController $company){
        if($request->isMethod('get')){
            return view('company.register');
        }
        $v = $this->validator($request->all());

        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v);
        }

        $user =  User::create([
            'email' => $request->all()['email'],
            'phone' => $request->all()['phone'],
            'password' => bcrypt($request->all()['password']),
        ]);


        if($user){
            Auth::login($user);

            $userinfo =  UserInformation::create([
                'name' => $request->all()['name'],
                'surname' => $request->all()['surname'],
                'date_birth' => $request->all()['date_birth'],
                'gender' => $request->all()['gender'],
                'location' => $request->all()['location'],
            ]);

            $com = new Company([
                'company_name' => $request->input('company')['company_name'],
                'company_description' => $request->input('company')['company_description'],
                'company_logo' => $request->input('company')['company_logo'],
                'company_content' => $request->input('company')['company_content'],
                'company_address' => $request->input('company')['company_address'],
                'company_contact_info' => $request->input('company')['company_contact_info'],
                'company_additional_info' => $request->input('company')['company_additional_info'],
            ]);

            $user->getUserInformation()->save($userinfo);
            $user->getCompanies()->save($com);
            return redirect()->intended('home');
        }

    }

}


