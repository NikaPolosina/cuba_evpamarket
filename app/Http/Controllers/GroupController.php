<?php

namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserMoney;
use App\Group;

class GroupController extends Controller{
    public function showGroupList(){
        $user_id = Auth::user();
        $my_group = $user_id->getGroup;


dd(Company::whereNotIn('id', $user_id->getGroup()->having('pivot_is_admin','=','1')->get()->lists('company_id'))->get());

        return view('group.groupShow')
           ->with('my_group', $my_group)
           ->with('my_company', $my_company);

    }
    public function createGroup(Request $request){
        $user_id = Auth::user();
        $userMoney = UserMoney::firstOrNew(array('user_id' => $user_id['id'], 'company_id' => $request['my_company']));
        $newGroup = new Group([
            'group_name'        => $request['group_name'],
            'company_id'        => $request['my_company'],
            'money'             =>  $userMoney['money'],

        ]);

        $user_id->getGroup()->save($newGroup, ['is_admin' => 1]);

        $my_group = $user_id->getGroup;
        $my_company = UserMoney::where(array('user_id' => $user_id['id']))->with(['getCompany'])->get();
        return view('group.groupShow')
            ->with('my_group', $my_group)
            ->with('my_company', $my_company);


    }

}
