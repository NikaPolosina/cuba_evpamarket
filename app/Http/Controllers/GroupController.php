<?php

namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserMoney;
use App\Group;
use App\StatusOwner;

class GroupController extends Controller{
    public function showGroupList(){
        $user_id = Auth::user();
        $my_group = $user_id->getGroup()->with(['getCompany'])->get();
        foreach($my_group as $item){
            $item->discount = 0;
            if($item->money){
                $item->discount = $item->getCompany->getDiscountAccumulativ()->where('from', '<=', $item->money)->orderBy('from', 'desc')->first();
                if($item->discount){

                    $item->discount =  $item->discount->percent;
                }else{
                    $item->discount = 0;
                }
            }
        }

        $my_company = Company::whereNotIn('id', $user_id->getGroup()->having('pivot_is_admin','=','1')->get()->lists('company_id'))->get();

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
        return redirect('/show-group-list');


    }
    public function singleGroup($id){

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




        $users = Group::find($id)->getUser()->with(['getUserInformation'])->get();


        return view('group.singleGroup')
            ->with('group', $group)
            ->with('discount', $discount)
            ->with('users', $users);

        
    }

}
