<?php

namespace App\Http\Controllers;

use App\Company;
use App\MemberGroupHistory;
use App\Models\Message;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserMoney;
use App\Group;
use App\StatusOwner;
use App\User;
use App\Http\Controllers\MessageController;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Creitive\Breadcrumbs\Breadcrumbs;

class GroupController extends Controller{

    protected $_group;
    protected $_groupModel;
    protected $_request;
    protected $_msg;
    protected $_breadcrumbs;

    /**
     * Class init
     * */
    
    public function __construct(Group $group, Request $request, MessageController $messageController,  Breadcrumbs $breadcrumbs){
        $this->_groupModel = $group;
        $this->_request = $request;
        $this->_msg = $messageController;
        $this->_breadcrumbs = $breadcrumbs;
    }

    public function prepareUserAvatar($user){
        foreach($user as $val){
            if(!is_file(public_path().$val['getUserInformation']['avatar'])){
                $val['getUserInformation']['avatar'] = '/img/placeholder/avatar.jpg';
            }
        }
        return $user;
    }


    public function showGroupList(){
        $user_id = Auth::user();
        $my_group = $user_id->getGroup()->with([ 'getCompany', 'getUser' ])->get();
        foreach($my_group as $item){
            $item->discount = 0;
            if($item->money){
                $item->discount = $item->getCompany->getDiscountAccumulativ()->where('from', '<=', $item->money)->orderBy('from', 'desc')->first();
                if($item->discount){

                    $item->discount = $item->discount->percent;
                }else{
                    $item->discount = 0;
                }
            }
        }


     

        $my_company = Company::whereNotIn('id', $user_id->getGroup()->having('pivot_is_admin', '=', '1')->get()->lists('company_id'))->get();

        $this->_msg->getGroupInvite(Auth::user(), [ 'status' => 0 ]);

        $groupInvites = $this->_msg->getMsg();

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Группы', '/show-group-list');



        
        return view('group.groupShow')
            ->with('my_group', $my_group)
            ->with('my_company', $my_company)
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('groupInvites', $groupInvites);
    }

    public function createGroup(Request $request){
        $user_id = Auth::user();

        $userMoney = UserMoney::firstOrNew(array(
            'user_id'    => $user_id['id'],
            'company_id' => $request['my_company']
        ));

        $newGroup = new Group([
            'group_name' => $request['group_name'],
            'company_id' => $request['my_company'],
            'money'      => $userMoney['money'],

        ]);

        $user_id->getGroup()->save($newGroup, [ 'is_admin' => 1 ]);
        return redirect('/show-group-list');
    }

    /**
     * Single groups screen
     * */
    public function showSingleGroup($id){

        $group = Group::find($id);
        $company = Company::where('id', $group->company_id)->first();

        if($group->money){
            $discount = $company->getDiscountAccumulativ()->where('from', '<=', $group->money)->orderBy('from', 'desc')->first();
            if($discount){
                $discount = $discount->percent;
            }else{
                $discount = 0;
            }
        }else{
            $group->money = 0;
            $discount = 0;
        }

        $users = Group::find($id)->getUser()->with([ 'getUserInformation' ])->get();
        $allUser = User::with([ 'getUserInformation' ])->whereNotIn('id', $users->lists('id'))->get();
        $this->prepareUserAvatar($allUser);
        $this->prepareUserAvatar($users);
        
        $region = Region::all();

        $msg = Message::where('to', Auth::user()->id)->where('connected_id', $group->id)->where('status', 0)->first();

        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Группы', '/show-group-list');
        $this->_breadcrumbs->addCrumb($group->group_name, '/single-group'.$group->id);

        
        return view('group.singleGroup')
            ->with('group', $group)
            ->with('discount', $discount)
            ->with('allUser', $allUser)
            ->with('users', $users)
            ->with('region', $region)
            ->with('breadcrumbs', $this->_breadcrumbs)
            ->with('msg', $msg);
    }
  

    /**
     * Get single group
     * */
    public function singleGroup($id, array $fields = array( '*' )){
        $this->_group = $this->_groupModel->select($fields)->find($id);
    }

    /**
     * Check if item exists
     * */
    public function checkExists($id){
        $this->_request->request->add([ 'item' => $id ]);
        $this->validate($this->_request, [
            'item' => 'required|exists:groups,id'
        ]);
    }
    /**
     * Check if item exists
     * */
    public function checkRole(){
        return $this->_group->getUser()->where('user_id', Auth::user()->id)->having('pivot_is_admin', '=', '1')->get()->count();
    }

    /**
     * Get current group
     *
     * @return mixed
     */
    public function getGroup(){
        return $this->_group;
    }

    /**
     *
     * Set current group
     *
     * @param mixed $group
     */
    public function setGroup(Group $group){
        $this->_group = $group;
    }

    /**
     * Get group model
     * */
    public function getModel(){
        return new $this->_groupModel;
    }

    /**
     * Ajax send invite
     * */
    public function ajaxInviteToGroup(){
        $this->checkExists($this->_request->input('group'));
        $this->validate($this->_request, [
            'user' => 'required'
        ]);
        try{
            $user = User::find($this->_request->input('user'));

            $a = $user->getGroup()->where('id', $this->_request->input('group'))->count();
            $b = Message::where('connected_id', $this->_request->input('group'))->where('to', $this->_request->input('user'))->where('status', 0)->count();
//         dd($a);
//            die('Surprise, you are here !!!');

            if(!$a && !$b){
                $this->_prepareInviteMsg();
                $this->_msg->sendMsg();
            }
            // проверяем есть ли он в группе
            // есть ли у него не прочитанные собщения с этой группы



            return response()->json([ 'success' => true ], 200);
        }catch(\Exception $e){
            return response()->json([ 'error' => $e->getMessage() ], 422);
        }
    }

    /**
     * Prepare invite msg
     * */
    protected function _prepareInviteMsg(){
        $this->_msg->setMsg($this->_msg->getModel());
        $this->_msg->setMsgParam('type', 'group');
        $this->_msg->setMsgParam('connected_id', $this->_request->input('group'));
        $this->_msg->setMsgParam('status', 0);
        $this->_msg->setMsgParam('from', Auth::user()->id);
        $this->_msg->setMsgParam('to', $this->_request->input('user'));
        $this->_msg->setMsgParam('subject', 'Invite to connect');
        $this->_msg->setMsgParam('body', 'Invite to connect body');
    }

    /**
     * Disable groups invite
     * */
    public function disableInvite($id){
        try{
            $this->_msg->singleMsg($id);
            $this->_msg->setAsReaded();
            Session::flash('flash_message', 'Disabled!');
            return redirect()->route('homeSimpleUser');
        }catch(\Exception $e){
            Session::flash('flash_message', 'Enabled');
            return Redirect::back();
        }
    }

    /**
     * Enable group invite
     * */
    public function enableInvite($id){

        $user = Auth::user();
        try{

            $this->_msg->singleMsg($id);
            $group = Group::find($this->_msg->getMsgParam('connected_id'));
            $userMoney = UserMoney::where('user_id', $user->id)->where('company_id', $group->getCompany->id)->first();
            $group_history = MemberGroupHistory::where('user_id', $user->id)->where('group_id', $group->id)->first();
            if($userMoney){
                if($group_history){
                    $group->money += ($userMoney->money - $group_history->money);
                    $group->save();
                    $group_history->money += ($userMoney->money - $group_history->money);
                    $group_history->save();
                }else{
                    $group_history = new MemberGroupHistory([
                        'user_id'  => $user->id,
                        'group_id' => $group->id,
                        'money'    => $userMoney->money
                    ]);
                    $group_history->save();
                    $group->money += $userMoney->money;
                    $group->save();
                }
            }
            $this->_msg->setAsReaded();
            $this->singleGroup($this->_msg->getMsgParam('connected_id'));
            $this->attachUser(Auth::user());
            Session::flash('flash_message', 'Disabled!');
            return redirect()->route('show-group-list');
        }catch(\Exception $e){
            Session::flash('flash_message', 'Enabled');
            return Redirect::back();
        }
    }

    /**
     * Attach user to group
     * */
    public function attachUser($user){
        $user->getGroup()->detach($this->_group);
        $user->getGroup()->attach($this->_group, [ 'is_admin' => 0 ]);
    }
    /**
     * Detach user to group
     * */
    public function detachUser($user){
        $user->getGroup()->detach($this->_group);
    }

    public function left($id){
        $this->checkExists($id);
        try{
            $this->singleGroup($id);
            $this->detachUser(Auth::user());
            Session::flash('flash_message', 'Disabled!');
            return Redirect::back();
        }catch(\Exception $e){
            Session::flash('flash_message', 'Enabled');
            return Redirect::back();
        }
    }
    public function destroy($id){
        $this->checkExists($id);
        try{
            $this->singleGroup($id);
            if(!$this->checkRole())
                throw new \Exception('Не админ');
            $this->delete();
            Session::flash('flash_message', 'Disabled!');
            return Redirect::back();
        }catch(\Exception $e){
            Session::flash('flash_message', 'Error');
            return Redirect::back();
        }
    }

    public function delete(){
        $this->_group->delete();
    }
}
