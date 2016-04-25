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



use App\Models\UserCompany;
use Illuminate\Support\Facades\DB;
//use Auth as AuthUser;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    public function registerCompany(Request $request, CompanyController $company){
        if($request->isMethod('get')){
            return view('company.register');
        }

        $v = $this->validator($request->all());
        if($v->fails()){
            return redirect()->back()->withInput()->withErrors($v);
        }


            $user = $this->create($request->all());

        if($user){
            Auth::login($user);
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

    }




}


