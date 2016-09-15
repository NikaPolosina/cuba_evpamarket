<?php
namespace App\Http\Controllers;

use App\Category;
use App\DiscountAccumulativ;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use App\Product;
use App\City;
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
use Creitive\Breadcrumbs\Breadcrumbs;

use Illuminate\Support\Facades\File;
class CompanyController extends Controller{
    protected $_breadcrumbs;
    public $category  = array();
    public $nCategory = array();
    
    public function __construct(Request $request,  Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
    }

    public function create(){
        $region = Region::all();
        $user = Auth::user()->getUserInformation;
        $city = City::where('region_id', $user->region_id)->get();


        return view('company.create')
            ->with('region', $region)
            ->with('city', $city)
            ->with('user', $user);
    }

    public function store(Request $request, Company $company){

        $company->company_name = $request['company_name'];
        $company->company_description = $request['company_description'];
        $company->company_logo = $request['company_logo'];
        /* 'company_content'     => $request['company_content'],*/
        $company->company_contact_info = $request['company_contact_info'];
        $company->region_id = $request->input('region');
        $company->city_id = $request->input('city');
        $company->street = $request->input('street');
        $company->address = $request->input('address');
        $company->country = 'Росcия';



        $curentUser = Auth::user();
        $curentUser->getCompanies()->save($company);

       if(!empty($request['company_logo'])){
           $dir = public_path().'/img/custom/companies/'.$company['id'];
           $dir_m = public_path().'/img/custom/companies/'.$company['id'].'/company';
           $source = public_path().'/img/custom/companies/'.$request['company_logo'];
           $dest  = public_path().'/img/custom/companies/'.$company['id'].'/company/'.$request['company_logo'];
           $dest_t  = public_path().'/img/custom/companies/'.$company['id'].'/company/thumbnail/'.$request['company_logo'];
           $dir_m_t = public_path().'/img/custom/companies/'.$company['id'].'/company/thumbnail';
           $source_t = public_path().'/img/custom/companies/thumbnail/'.$request['company_logo'];
           if(!is_dir($dir)){
               mkdir($dir, 0700, true) ;
               mkdir($dir_m,  0700, true) ;
               mkdir($dir_m_t,  0700, true) ;
           }
           File::move($source, $dest);
           File::move($source_t, $dest_t);
           File::deleteDirectory(public_path().'/img/custom/companies/thumbnail');
       }

        return view('company.companyContent')->with('company_id', $company['id']);
    }

    public function companyContent(Request $request){

        $id = $request['company_id'];
        $company = Company::find($id);
        $company_content = [
            'company_content' => $request['company_content']
        ];
        $company->update($company_content);

        return redirect()->route('homeOwnerUser');
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


    public function showCompanyLogo($id){

        $company = Company::findOrFail($id);
        if(file_exists(public_path() . '/img/custom/companies/' .$company->id.'/company/thumbnail/'. $company->company_logo) && !empty($company->company_logo)){
            $img = '/img/custom/companies/' .$company->id.'/company/thumbnail/'. $company->company_logo;
        }else{
            $img = '/img/custom/files/thumbnail/plase.jpg';
        }
        return $img;
    }

    public function show($id, CategoryController $category){

        $company = Company::findOrFail($id);
        $img = $this->showCompanyLogo($company->id);
        $res = $company->getProducts;
        $productAll = IndexController::showProduct($res);
        return view('company.show')->with('company', $company)->with('img', $img)->with('category', $category->getAllCategoris())->with('productAll', $productAll);
    }

    public function edit($id){

        $company = Company::findOrFail($id);
        $region = Region::all();
        $city = City::where('region_id', $company->region_id)->get();
        return view('company.edit', compact('company'))
            ->with('city', $city)
            ->with('region', $region);

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
        $dir = public_path().'/img/custom/companies/'.$id;
       if(is_dir($dir)){
           File::deleteDirectory($dir);
       }
        Company::destroy($id);

        Session::flash('flash_message', 'Company deleted!');
        return response($id);

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

        $max['from'] = $company->getDiscountAccumulativ()->max('from')+1;
        $max['percent'] = $company->getDiscountAccumulativ()->max('percent')+1;

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Магазин - '.$company->company_name, '/product-editor/'.$company->id);
        $this->_breadcrumbs->addCrumb('Установка скидок', '/company-discount-setup/'.$company->id);

        return view('company.setupDiscount')
            ->with('discount', $discount)
            ->with('max', $max)
            ->with('company', $company)
            ->with('breadcrumbs', $this->_breadcrumbs);
    }

    public function createDiscount($id, Request $request){

        $company = Company::find($id);

        if(empty($request['id'])){

            $max['from'] = $company->getDiscountAccumulativ()->max('from')+1;
            $max['percent'] = $company->getDiscountAccumulativ()->max('percent')+1;

            $this->validate($request, [
                'from'=> 'required|integer|min:'.$max['from'],
                'percent' => 'required|integer|min:'.$max['percent']
            ]);

            $newDiscount = DiscountAccumulativ::create([
                'from'       => $request['from'],
                'percent'    => $request['percent'],
                'company_id' => $id
            ]);

            if($newDiscount){
                $company = Company::find($id);
                $company->getDiscountAccumulativ()->save($newDiscount);
            }
        }else{

            $currentDiscount = $company->getDiscountAccumulativ()->where('id', $request->input('id'))->first()->toArray();
            $min = $company->getDiscountAccumulativ()->where('id', '!=', $request->input('id'))->where('from', '<', $currentDiscount['from'])->orderBy('from', 'desc')->first();
            $max = $company->getDiscountAccumulativ()->where('id', '!=', $request->input('id'))->where('from', '>', $currentDiscount['from'])->orderBy('from', 'asc')->first();

            if($min){
                $this->validate($request, [
                    'from'    => 'required|integer|min:'.($min->from + 1),
                    'percent' => 'required|integer|min:'.($min->percent + 1).'|max:99'
                ]);
            }


            if($max){
                $this->validate($request, [
                    'from'    => 'required|integer|min:0|max:'.($max->from - 1),
                    'percent' => 'required|integer|min:1|max:'.($max->percent - 1)
                ]);
            }

            $discount_single = DiscountAccumulativ::findOrFail($request['id']);
            $discount_single->from = $request['from'];
            $discount_single->percent = $request['percent'];
            $discount_single->save();
        }
        return redirect()->intended('company-discount-setup/' . $id);
    }

    public function destroyDiscount($company_id, $discount_id){
        $company = Auth::user()->getCompanies()->where('id', $company_id)->first();
        $company->getDiscountAccumulativ()->where('id', $discount_id)->first()->delete();
        return redirect()->back();
    }
}
