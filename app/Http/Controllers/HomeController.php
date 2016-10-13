<?php
namespace App\Http\Controllers;

use App\Http\Requests;
//use Faker\Provider\pl_PL\Company;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\UserCompany;
use App\User;
use App\Company;
use App\Region;
use App\City;
use App\Http\Controllers\CategoryController;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\UserInformation;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Cookie;
use Creitive\Breadcrumbs\Breadcrumbs;
use App\ChatUsers;
use App\StatusOwner;
class HomeController extends Controller{
    protected $_msg;
    protected $_companyController;
    protected $_breadcrumbs;

    public function __construct(MessageController $messageController, CompanyController $companyController, Breadcrumbs $breadcrumbs){
        $this->middleware('auth');
        $this->_msg = $messageController;
        $this->_companyController = $companyController;
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider('<img style="display: inline-block;  height: 37px;" src="/img/system/next-bread.png">');
    }

    public function Index(Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs->addCrumb('Домой', '/login-user');

        /*Cookie::queue(
            Cookie::forget('cart')
        );*/
        if(Auth::user()->hasRole('admin')){
            return redirect()->intended('admin');
        }
        if(Auth::user()->hasRole('company_owner')){
            return redirect()->intended('homeOwnerUser')->with('breadcrumbs', $this->_breadcrumbs);
        }
        if(Auth::user()->hasRole('simple_user')){
            return redirect()->intended('homeSimpleUser')->with('breadcrumbs', $this->_breadcrumbs);
        }
    }


    public function getUserPageWithConversationUsers($from_id, $to_id, MessageController $mesage, ChatUsers $chatUsers){

        if(!Auth::user()->getUserInformation){
            $region = Region::all();
            return view('auth.register_aditional')->with('region', $region);
        }
        if(Auth::check()){
            $curentUser = Auth::user();
            $userInfo = $curentUser->getUserInformation;
            $companies = $curentUser->getCompanies;
            $order = Order::where('simple_user_id', '=', Auth::user()->id)->get();
            $this->_msg->getGroupInvite(Auth::user(), [ 'status' => 0 ]);
            $groupInvites = $this->_msg->getMsg()->count();
            $userInfo['msgAll'] = $mesage->getAllUserWhoSendMsg(Auth::user()->id);
        }

        //dd($userInfo);

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $product = [];
        $curentUser = Auth::user();
        $product = $curentUser->getProduct;
        $product = IndexController::showProduct($product);

        $data['userInfo'] = $userInfo;
        $data['order'] = $order;
        $data['user'] = $curentUser;
        $data['groupInvites'] = $groupInvites;
        $data['product'] = $product;


        $between = $mesage->getChatBetweenTwoUser($from_id, $to_id);
        $data['userInfo']['beetwenTwo'] = $between;

        $conversation = $chatUsers->whereIn('from_id', [$from_id, $to_id])
            ->whereIn('to_id', [$from_id, $to_id])
            ->with([
                'getUserFrom' => function($query){
                   $query->with('getUserInformation');
                },
                'getUserTo' => function($query){
                    $query->with('getUserInformation');
                }
            ])->first();

        if(!$conversation){
            $conversation = $chatUsers;
            $conversation->from_id = Auth::user()->id;
            $conversation->to_id = $to_id;
            $conversation->save();
        }

        if($conversation){
            if($conversation->from_id == $data['userInfo']->id){
                $to = $conversation->getUserTo;
                $from = $conversation->getUserFrom;
            }else{
                $to = $conversation->getUserFrom;
                $from = $conversation->getUserTo;
            }
        }


        if(!$to->getUserInformation->avatar){
            $to->getUserInformation->avatar = '/img/placeholder/avatar.jpg';
        }else{
            if(!file_exists(public_path().$to->getUserInformation->avatar)){
                $to->getUserInformation->avatar = '/img/placeholder/avatar.jpg';
            }
        }
        if(!$from->getUserInformation->avatar){
            $from->getUserInformation->avatar = '/img/placeholder/avatar.jpg';
        }else{
            if(!file_exists(public_path().$from->getUserInformation->avatar)){
                $from->getUserInformation->avatar = '/img/placeholder/avatar.jpg';
            }
        }
        
        // avatar check


        if(Auth::user()->hasRole('company_owner')){
            foreach(Auth::user()->getCompanies as $value){
                $value->company_logo = $this->_companyController->showCompanyLogo($value->id);
            }

            $ya = User::where('id', Auth::user()->id )->with(['getCompanies' => function($query){
                $query->with(['getOrder' => function ($query){
                    $query->where('status', StatusOwner::where('key', 'not_processed')->first([ 'id' ])->id);
                }
                ]);
            }])->first()->toArray();


            $count = 0;
            foreach($ya['get_companies'] as $it){
                $count = $count + count($it['get_order']);

            }

            return view('homeOwnerUser')
                ->with('userInfo', $userInfo)
                ->with('curentUser', Auth::user())
                ->with('groupInvites', $this->_msg->getMsg()->count())
                ->with('breadcrumbs', $this->_breadcrumbs)
                ->with('conversation', $conversation)
                ->with('count', $count)
                ->with('from', $from)
                ->with('to', $to);
        }



        return view('user.simple_user.home')
            ->with('userInfo', $data['userInfo'])
            ->with('order', $data['order'])
            ->with('user', $data['user'])
            ->with('groupInvites', $data['groupInvites'])
            ->with('product', $data['product'])
            ->with('conversation', $conversation)
            ->with('from', $from)
            ->with('to', $to)
            ->with('breadcrumbs', $this->_breadcrumbs);

    }

        public function registerSimple(MessageController $mesage){
            if(!Auth::user()->getUserInformation){
                $region = Region::all();
                return view('auth.register_aditional')->with('region', $region);
            }
            if(Auth::check()){
                $curentUser = Auth::user();
                $userInfo = $curentUser->getUserInformation;
                $companies = $curentUser->getCompanies;
                $order = Order::where('simple_user_id', '=', Auth::user()->id)->get();
                $this->_msg->getGroupInvite(Auth::user(), [ 'status' => 0 ]);
                $groupInvites = $this->_msg->getMsg()->count();
                $userInfo['msgAll'] = $mesage->getAllUserWhoSendMsg(Auth::user()->id);
            }

            $this->_breadcrumbs->addCrumb('Домой', '/login-user');
            $product = [];
            $curentUser = Auth::user();
            $product = $curentUser->getProduct;
            $product = IndexController::showProduct($product);

            $data['userInfo'] = $userInfo;
            $data['order'] = $order;
            $data['user'] = $curentUser;
            $data['groupInvites'] = $groupInvites;
            $data['product'] = $product;

        return view('user.simple_user.home')
            ->with('userInfo', $data['userInfo'])
            ->with('order', $data['order'])
            ->with('user', $data['user'])
            ->with('groupInvites', $data['groupInvites'])
            ->with('product', $data['product'])
            ->with('breadcrumbs', $this->_breadcrumbs);
    }

    public function registerOwner(MessageController $mesage ){


        if(Auth::check()){
            foreach(Auth::user()->getCompanies as $value){
                $value->company_logo = $this->_companyController->showCompanyLogo($value->id);
            }
            $userInfo = Auth::user()->getUserInformation;
            $this->_msg->getGroupInvite(Auth::user(), [ 'status' => 0 ]);
            $userInfo['msgAll'] = $mesage->getAllUserWhoSendMsg(Auth::user()->id);
        }
        $this->_breadcrumbs->addCrumb('Домой', '/login-user');

        $ya = User::where('id', Auth::user()->id )->with(['getCompanies' => function($query){
            $query->with(['getOrder' => function ($query){
                $query->where('status', StatusOwner::where('key', 'not_processed')->first([ 'id' ])->id);
            }
            ]);
        }])->first()->toArray();


        $count = 0;
        foreach($ya['get_companies'] as $it){
            $count = $count + count($it['get_order']);

        }




        return view('homeOwnerUser')
            ->with('userInfo', $userInfo)
            ->with('curentUser', Auth::user())
            ->with('groupInvites', $this->_msg->getMsg()->count())
            ->with('count', $count)
            ->with('breadcrumbs', $this->_breadcrumbs);
    }

}
