<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Category;
use App\City;
use App\Http\Requests;
use App\Region;
use Illuminate\Http\Request;
use App\User;
use App\UserInformation;
use App\Company;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\AdditionParam;

class AdminController extends Controller{

    protected function validatorCategory(array $data){
        return Validator::make($data, [
            'parent_id' => 'required|integer',
            'title' => 'required|string|max:40'
        ]);
    }

    public function index(){
        return view('admin.home');
    }
    
    
    public function AdditionParamList(){
        $param = AdditionParam::all();
        return view('admin.addParam.list')->with('param', $param);
    }
    public function AdditionParamShowItem($id){
        $param = AdditionParam::where('id', $id)->first();
        $param->value = json_decode($param->value, true);
        return view('admin.addParam.show')->with('param', $param);
    }
    public function AdditionParamAdd(){
        return view('admin.addParam.add');
    }

     public function createAddParam(Request $request){
        // dd($request->all());


         $addParam = new AdditionParam([
             'title'         => $request['title'],
             'description'  => $request['description'],
             'placeholder'         => $request['placeholder'],
             'type'         => $request['type'],
             'required'      => $request['required'],
             'sort'      => $request['sort'],
             'default'      => $request['default'],
             'value'      => json_encode($request['value'])

         ]);
         $addParam->save();

         //dd($addParam);

        return view('admin.addParam.add');
    }

    public function allUser(){
        $user = User::all();
        return view('admin.user.show')->with('user', $user);
    }

    public function userMan(User $user){
        $user = User::whereIn('id', UserInformation::where('gender', '1')->lists('user_id'))->get();
        return view('admin.user.show')->with('user', $user);
    }

    public function userWomen(){
        $user = User::whereIn('id', UserInformation::where('gender', '0')->lists('user_id'))->get();
        return view('admin.user.show')->with('user', $user);
    }

    public function userBlocked(){
        $user = User::where('block', 1)->get();
        return view('admin.user.show')->with('user', $user);
    }
    
    public function shopAll(){
        $shop = Company::all();
        return view('admin.company.show')->with('shop', $shop);
    }

    /**
     * Просмотр дополнительных параметров товара по данной категории. Принимаем $id;
     *
     * @param int $id - id категории
     *
     * @return View
     * */
    public function addCategoryAddParam($id, Request $request){
        if($request->isMethod('post')){
            $category = Category::find($request->input('category_id'));
            $category->getAddParam()->sync($request->input('param_id', array()));
        }else{
            $category = Category::where('id', $id)->with('getAddParam')->first();
        }
        $category->getAddParam = $category->getAddParam->lists('id')->toArray();
        $addParam = AdditionParam::all();
        foreach($addParam as $item){
            $item->value = json_decode($item->value, true);
        }

        return view('admin.category.showAddParam')->with('category', $category)->with('addParam', $addParam);
    }


    public function destroyAddParam($id){
        if(Auth::user()->hasRole('admin')){
            AdditionParam::destroy($id);
        }
        return redirect()->back();
    }
    
    public function shopBlocked(){
        $shop = Company::where('block', 1)->get();
        return view('admin.company.show')->with('shop', $shop);
    }
    
    public function shopStatistic($id){


        $company = Company::find($id);

        $company->perDayAmount = OrderController::getAmount($company->id, 0);
        $company->perWeekAmount = OrderController::getAmount($company->id, 7);
        $company->totalAmount = OrderController::getAmount($company->id, 365);
        $chData =  $this->chData($id);
        
        return view('admin.company.aboutSingleShop')->with('company', $company)->with('chart', $chData);
    }
    public function chData($id){
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $orsders = Company::find($id)
            ->getOrder()
            ->select([DB::raw('sum(order.total_price) AS total_sales'), 'order.updated_at'])
            ->where('status', 16)
            ->whereBetween('updated_at', [
                $monthStart,
                $monthEnd
            ])
            ->groupBy('updated_at')
            ->get();
        $chartData = array();
        foreach ($orsders as $day) {
            $chartData[$day->updated_at->format('Y-m-d')] = $day->total_sales;
        }
        $days = Carbon::today()->daysInMonth;

        $chData = array();
        for($i = 0; $i < $days; $i++){
            $date = Carbon::now()->startOfMonth()->addDay($i)->format('Y-m-d');
            $money = 0;
            if(array_key_exists($date, $chartData)){
                $money = $chartData[$date];
            }

            $chData[] = array('data'=>Carbon::now()->startOfMonth()->addDay($i)->format('Y-m-d'), 'money'=>$money);
        }
        return $chData;

    }
    public function category(){
        $category = Category::all();
        return view('admin.category.show')->with('category', $category);
    }
    public function categoryAdd(){

        $category = Category::all();
        $category_parent = Category::where('parent_id', 0)->get();
        $child_category = Category::where('parent_id', $category_parent[0]->id)->get();

        return view('admin.category.add')
            ->with('category', $category)
            ->with('category_parent', $category_parent)
            ->with('child_category', $child_category);
    }
    public function categoryAddList(Request $request){
        $id = $request['id'];
        $category_child = Category::where('parent_id', $id)->get();
        return response()->json([
            'category_child'  => $category_child
        ]);
    }
    public function categoryAddItem(Request $request){
        $response = json_decode($request['arr'], true);

        foreach($response as $val){
            $v = $this->validatorCategory($val);
            if($v->fails()){
                return response()->json([
                    'errors'  => $v->messages()
                ]);
            }

            if( $val['title'] == ''){

            }else{
                $newCategory = new Category([
                    'parent_id'        => $val['parent_id'],
                    'title'            => $val['title']
                ]);

                $newCategory->save();
            }



        }





    }
    public function categoryDestroy($id){

        if(Auth::user()->hasRole('admin')){
            Category::destroy($id);
        }
        return redirect()->back();

    }
    
    public function categoryUpdate(Request $request){


        $category = Category::findOrFail($request['id']);
        $updateCategory = [
            'title'         => $request['title'],

        ];
        $category->update($updateCategory);

        return redirect()->back();
    }

    public function cityUpdate(Request $request){

        $city = City::where('id_cities', $request['id_cities'])->get();
        $updateCity = [
            'title_cities' =>$request['title'],
        ];

        $city['0']->update($updateCity);
        return redirect()->back();
    }

    public function cityDestroy($id){
        if(Auth::user()->hasRole('admin')){

            $city = City::where('id_cities', $id)->get();

           //dd($city[0]['id']);

            City::destroy($city[0]['id']);
        }
        return redirect()->back();
    }

    public function userBlock(Request $request){
        $user = User::find($request['id']);
        if($user['block'] == 1){
            $block = 0;
        }else{
            $block = 1;
        }

        $user['block'] = $block;
            $user->save();
        
        return response()->json([
            'block'  => $block
        ]);
    }

    public function regionList(){
        $region = Region::all();
        return view('admin.region.list')->with('region', $region);
    }
    
    public function regionSingle($id){
        $region = Region::where('id_region', $id)->get()->toArray();
        $city = City::where('region_id', $id)->get();

        return view('admin.region.addRegionCity')
            ->with('region', $region)
            ->with('city', $city);
        
    }

    
   

}