<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\UserInformation;
use App\Company;
use Validator;

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
    public function shopBlocked(){
        $shop = Company::where('block', 1)->get();
        return view('admin.company.show')->with('shop', $shop);
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

}