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
use App\Region;
use App\City;

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
            'region' => 'required|max:255',
            'city' => 'required|max:255',
            'street' => 'max:255',
            'address' => 'max:255',
        ]);
    }
    protected function create(array $data){

        $user = User::create([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        $role = Role::findOrFail(2);

        $user->attachRole($role);
        return $user;
    }

/*    public function registerCompany(Request $request, CompanyController $company){
        die('Surprise, you are here1 !!!');


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



    }*/

    public function registerAditional(Request $request){
        $userinfo =  Auth::user()->getUserInformation;
       if(!Auth::user()->getUserInformation){
           $v = $this->myValidator($request->all());
           if($v->fails()){
               return redirect()->back()->withInput()->withErrors($v);
           }
           if(Auth::user()){
               $userinfo = UserInformation::create([
                   'name'       => $request->input('name'),
                   'surname'    => $request->input('surname'),
                   'date_birth' => $request->input('date_birth'),
                   'gender'     => $request->input('gender'),
                   'region_id'  => $request->input('region'),
                   'city_id'    => $request->input('city'),
                   'street'     => $request->input('street'),
                   'address'    => $request->input('address'),
                   'country'    => 'Росcия',
               ]);
               Auth::user()->getUserInformation()->save($userinfo);
           }
       }
        return view('auth/askForShop')->with('userInfo', $userinfo);
    }

    public function registerC(){
        return view('auth.register')/*->withCompany(true)*/;
    }


      public function createRegion(){
               $lang = 0; // russian
               $headerOptions = array(
                   'http' => array(
                       'method' => "GET",
                       'header' => "Accept-language: en\r\n" .
                           "Cookie: remixlang=$lang\r\n"
                   )
               );
               $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&code=RU&count=1000';
               $streamContext = stream_context_create($headerOptions);
               $json = file_get_contents($methodUrl, false, $streamContext);
               $arr = json_decode($json, true);

               foreach ($arr['response']['items'] as $value) {
                   echo '<pre>';
                   var_dump('===================================='.$value['title'].'====================================');
                   echo '</pre>';
                   $countryId = $value['id']; // Russia
                   $lang = 0; // russian
                   $headerOptions = array(
                       'http' => array(
                           'method' => "GET",
                           'header' => "Accept-language: en\r\n" . // Вероятно этот параметр ни на что не влияет
                               "Cookie: remixlang=$lang\r\n"
                       )
                   );
                   $methodUrl = 'http://api.vk.com/method/database.getRegions?v=5.5&need_all=1&offset=0&count=1000&country_id=' . $countryId;
                   $streamContext = stream_context_create($headerOptions);
                   $json = file_get_contents($methodUrl, false, $streamContext);
                   $arr = json_decode($json, true);
                   foreach ($arr['response']['items'] as $value) {
                       Region::create([
                           'title' => $value['title'],
                           'id_region' => $value['id'],
                       ]);

                   }
               }

           }
      public function createSeaty(){
          $countryId = 1;
          $lang = 0;
          $headerOptions = array(
              'http' => array(
                  'method' => "GET",
                  'header' => "Accept-language: en\r\n" . // Вероятно этот параметр ни на что не влияет
                      "Cookie: remixlang=$lang\r\n"
              )
          );
            foreach(Region::all() as $val){
                set_time_limit(0);

               $regionId = $val->id_region;
               $regionTitle = $val->title;
                $methodUrl = 'http://api.vk.com/method/database.getCities?v=5.5&country_id=' . $countryId .'&region_id=' . $regionId . '&offset=0&need_all=1&count=1000';
                $streamContext = stream_context_create($headerOptions);
                $json = file_get_contents($methodUrl, false, $streamContext);
                $arr = json_decode($json, true);

                foreach($arr['response']['items'] as $value){


                      $cityInfo = City::create([
                       'title_cities' => $value['title'],
                       'id_cities' => $value['id'],
                   ]);
                    Region::find($val->id)->getCities()->save($cityInfo);
                }

            }
       }


}


