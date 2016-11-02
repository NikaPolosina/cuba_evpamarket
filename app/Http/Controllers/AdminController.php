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
use Creitive\Breadcrumbs\Breadcrumbs;

class AdminController extends Controller{
    /**
     * Current parameter obj
     * */
    protected $_param;
    protected $_breadcrumbs;

    //Конструктор. Выполняется всегда первым.
    public function __construct( Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider(' <i class="fa fa-angle-right"></i>');
    }

    //Валиация категорий
    protected function validatorCategory(array $data){
        return Validator::make($data, [
            'parent_id' => 'required|integer',
            'title'     => 'required|string|max:40'
        ]);
    }
    
    //Домашняя страница администратора.
    public function index(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        return view('admin.home')->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Выводит список юзеров всех.
    public function allUser(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Все пользователи', '/admin/user');
        $user = User::all();
        return view('admin.user.show')->with('user', $user)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод для вывода пользователей мужского пола.
    public function userMan(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Мужчины', '/admin/user-man');
        $user = User::whereIn('id', UserInformation::where('gender', '1')->lists('user_id'))->get();
        return view('admin.user.show')->with('user', $user)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод для вывода пользователей женского пола.
    public function userWomen(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Женщины', '/admin/user-women');
        $user = User::whereIn('id', UserInformation::where('gender', '0')->lists('user_id'))->get();
        return view('admin.user.show')->with('user', $user)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод для блокировки пользователя.
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
            'block' => $block
        ]);
    }
    
    //Метод для вывода всех заблокированных пользователей.
    public function userBlocked(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Заблокированные пользователи', '/admin/user-blocked');
        $user = User::where('block', 1)->get();
        return view('admin.user.show')->with('user', $user)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод для вывода всех магазинов зарегестрированных в системе.
    public function shopAll(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Все магазины', '/admin/shop-all');
        $shop = Company::all();
        return view('admin.company.show')->with('shop', $shop)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод который выводит список заблокированых магазинов.
    public function shopBlocked(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Заблокированные магазины', '/admin/shop-block');
        $shop = Company::where('block', 1)->get();
        return view('admin.company.show')->with('shop', $shop)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод для вывода списка дополнительных параметров при содании товара.
    public function AdditionParamList(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Дополнительные параметры', '/admin/addition-param-list');
        $param = AdditionParam::all();
        return view('admin.addParam.list')->with('param', $param)->with('breadcrumbs', $this->_breadcrumbs);
    }
    /**
     * Add / Edit additional param
     *
     * @param integer $id
     *
     * @return View
     * */
    //Метод направляет на страницу создания дополнительного параметра.
    public function additionParamAdd($id = NULL){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Форма создания дополнитеьного параметра', '/admin/addition-param-add/{id?}');
        if($id){
            $this->_param = AdditionParam::find($id);
            $this->_param->value = json_decode($this->_param->value, true);
        }
        return view('admin.addParam.add')->with('param', $this->_param)->with('breadcrumbs', $this->_breadcrumbs);
    }
    /**
     * Create / Edit param Создание дополнительного параметра.
     * */
    //Метод который создает дополнительный параметр.
    public function createAddParam(Request $request){
        // dd($request->all());
        if($request->has('id')){
            $this->_param = AdditionParam::find($request['id']);
        }else{
            $this->_param = new AdditionParam();
        }
        $this->_param->title = $request['title'];
        $this->_param->key = $request['key'];
        $this->_param->description = $request['description'];
        $this->_param->placeholder = $request['placeholder'];
        $this->_param->type = $request['type'];
        $this->_param->type_for_by = $request['type_for_by'];
        $this->_param->required = $request['required'];
        $this->_param->sort = $request['sort'];
        $this->_param->default = $request['default'];
        $this->_param->request = $request['request'];

        if(is_array($request->input('value'))){
            $value = $request->input('value');

            foreach($value as $key => $item){

                if(empty($item['css'])){
                    unset($value[$key]['css']);
                }

                if(empty($item['name'])){
                    unset($value[$key]);
                }
            }

            $this->_param->value = json_encode($value);
            unset($value);
        }else{
            $this->_param->value = '';
        }

        $this->_param->save();

        return redirect(route('addition_param_list'));
    }

    //Метод для просмотра дополнительного параметра.
    public function AdditionParamShowItem($id){
        $param = AdditionParam::where('id', $id)->first();
        $param->value = json_decode($param->value, true);
        return view('admin.addParam.show')->with('param', $param);
    }
    /**
     * Просмотр дополнительных параметров товара по данной категории. Принимаем $id;
     *
     * @param int $id - id категории
     *
     * @return View
     * */
    //Метод для построения связи между категорией товара и дополнительнымы параметрами товара.
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

    //Метод удаление дополнитеьного параметра по товару.
    public function destroyAddParam($id){
        if(Auth::user()->hasRole('admin')){
            AdditionParam::destroy($id);
        }
        return redirect()->back();
    }

    //Метод вывода статистики по каждому магазину.
    public function shopStatistic($id){
        $company = Company::find($id);
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Сатистика по магазину - '.$company->company_name, '/admin/company_statistic/'.$id);

        $company->perDayAmount = OrderController::getAmount($company->id, 0);
        $company->perWeekAmount = OrderController::getAmount($company->id, 7);
        $company->totalAmount = OrderController::getAmount($company->id, 365);
        $chData = $this->chData($id);

        return view('admin.company.aboutSingleShop')->with('company', $company)->with('chart', $chData)->with('breadcrumbs', $this->_breadcrumbs);
    }

    //Метод для выыода списка категорий.
    public function category(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Список категорий', '/admin/category');
        $category = Category::all();
        return view('admin.category.show')->with('category', $category)->with('breadcrumbs', $this->_breadcrumbs);
    }

    //Метод для перенаправления на форму создания новой категории товаров.
    public function categoryAdd(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Форма создания новой категории', '/admin/category-add');
        $category = Category::all();
        $category_parent = Category::where('parent_id', 0)->get();
        $child_category = Category::where('parent_id', $category_parent[0]->id)->get();
        return view('admin.category.add')->with('category', $category)->with('category_parent', $category_parent)->with('child_category', $child_category)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод создания новой категории.
    public function categoryAddItem(Request $request){
        $response = json_decode($request['arr'], true);
        foreach($response as $val){
            $v = $this->validatorCategory($val);
            if($v->fails()){
                return response()->json([
                    'errors' => $v->messages()
                ]);
            }

            if($val['title'] == ''){
            }else{
                $newCategory = new Category([
                    'parent_id' => $val['parent_id'],
                    'title'     => $val['title']
                ]);

                $newCategory->save();
            }
        }
    }

    //Список родительских категорий нужен для создания категории. Метод берет всех детей родительской категории.
    public function categoryAddList(Request $request){

        $id = $request['id'];
        $category_child = Category::where('parent_id', $id)->get();
        return response()->json([
            'category_child' => $category_child
        ]);
    }

    //Метод для удаления категории.
    public function categoryDestroy($id){

        if(Auth::user()->hasRole('admin')){
            Category::destroy($id);
        }
        return redirect()->back();
    }

    //Редактирование категории.
    public function categoryUpdate(Request $request){

        $category = Category::findOrFail($request['id']);
        $updateCategory = [
            'title' => $request['title'],

        ];
        $category->update($updateCategory);

        return redirect()->back();
    }

    //Метод выводит список всех регионов.
    public function regionList(){
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Список регионов', '/admin/region-list');
        $region = Region::all();
        return view('admin.region.list')->with('region', $region)->with('breadcrumbs', $this->_breadcrumbs);
    }

    //Страница просмотра региона.
    public function regionSingle($id){
        $region = Region::where('id_region', $id)->first();
        $city = City::where('region_id', $id)->get();
        $this->_breadcrumbs->addCrumb('Домой', '/admin/');
        $this->_breadcrumbs->addCrumb('Регион - '.$region->title, '/admin/single-region/'.$id);
        return view('admin.region.addRegionCity')->with('region', $region)->with('city', $city)->with('breadcrumbs', $this->_breadcrumbs);
    }
    
    //Метод который удаляет город.
    public function cityDestroy($id){
        if(Auth::user()->hasRole('admin')){

            $city = City::where('id_cities', $id)->get();

            //dd($city[0]['id']);

            City::destroy($city[0]['id']);
        }
        return redirect()->back();
    }

    //Мтод для редактирования города.
    public function cityUpdate(Request $request){

        $city = City::where('id_cities', $request['id_cities'])->get();
        $updateCity = [
            'title_cities' => $request['title'],
        ];

        $city['0']->update($updateCity);
        return redirect()->back();
    }

  

    public function chData($id){
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $orsders = Company::find($id)->getOrder()->select([
            DB::raw('sum(order.total_price) AS total_sales'),
            'order.updated_at'
        ])->where('status', 16)->whereBetween('updated_at', [
            $monthStart,
            $monthEnd
        ])->groupBy('updated_at')->get();
        $chartData = array();
        foreach($orsders as $day){
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

            $chData[] = array(
                'data'  => Carbon::now()->startOfMonth()->addDay($i)->format('Y-m-d'),
                'money' => $money
            );
        }
        return $chData;
    }
}