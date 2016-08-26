<?php

namespace App\Http\Controllers;

use App\Company;
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

class GroupController extends Controller{

    protected $_group;
    protected $_groupModel;
    protected $_request;
    protected $_msg;

    /**
     * Class init
     * */
    public function __construct(Group $group, Request $request, MessageController $messageController){
        $this->_groupModel = $group;
        $this->_request = $request;
        $this->_msg = $messageController;
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
        
        return view('group.groupShow')
            ->with('my_group', $my_group)
            ->with('my_company', $my_company)
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
        foreach($allUser as $val){
            if(!is_file(public_path().$val['getUserInformation']['avatar'])){
                $val['getUserInformation']['avatar'] = '/img/placeholder/avatar.jpg';
            }
        }
        foreach($users as $val){
            if(!is_file(public_path().$val['getUserInformation']['avatar'])){
                $val['getUserInformation']['avatar'] = '/img/placeholder/avatar.jpg';
            }
        }
        $region = Region::all();

        return view('group.singleGroup')->with('group', $group)->with('discount', $discount)->with('allUser', $allUser)->with('users', $users)->with('region', $region);
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
            $this->_prepareInviteMsg();
            $this->_msg->sendMsg();
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
            $group=Group::find($this->_msg->getMsgParam('connected_id'));
            $userMoney = UserMoney::where('user_id', $user->id)->where('company_id', $group->getCompany->id)->first();
            $group->money += $userMoney->money;
            $group->save();
            $this->_msg->setAsReaded();
            $this->singleGroup($this->_msg->getMsgParam('connected_id'));
            $this->attachUser(Auth::user());
            Session::flash('flash_message', 'Disabled!');
            return redirect()->route('homeSimpleUser');
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
