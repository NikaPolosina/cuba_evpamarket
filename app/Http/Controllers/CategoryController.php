<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller{

    public function checkCat($search, $arr){
        foreach($arr as $value){
            if($search == $value['id']){
                return false;
            }
        }
        return true;
    }

    public function getAllCategoris(){
        $category = Category::all()->toArray();
        $nCategory = array();
        foreach($category as $value){
            $value['text'] = $value['title'];
            $value['href'] = $value['id'];
            $value['nodes'] = array();
            $nCategory[$value['parent_id']][] = $value;
        }
        ksort($nCategory);
        $nCategory = array_reverse($nCategory, true);
        foreach($nCategory as $key => $value){
            foreach($value as $k => $v){
                if(array_key_exists($v['id'], $nCategory)){
                    $nCategory[$key][$k]['nodes'] = $nCategory[$v['id']];
                    unset($nCategory[$v['id']]);
                }
            }
        }
        return $nCategory[0];
    }

    public function kSortCategory($id){
        $company = Company::findOrFail($id);
        $this->category = array();
        foreach($company->getProducts as $value){
            $parentId = $value->getCategory->toArray()['parent_id'];
            if(!$this->checkCat($value->getCategory->toArray()['id'], $this->category)){
                continue;
            }
            $this->category[] = $value->getCategory->toArray();
            do{
                $current = Category::find($parentId)->toArray();
                $parentId = $current['parent_id'];
                if(!$this->checkCat($current['id'], $this->category)){
                    break;
                }
                $this->category[] = $current;
            }while($parentId != 0);
        }
        foreach($this->category as $value){
            $value['text'] = $value['title'];
            $value['href'] = $value['id'];
            $value['nodes'] = array();
            $this->nCategory[$value['parent_id']][] = $value;
        }
        ksort($this->nCategory);
        $this->nCategory = array_reverse($this->nCategory, true);
        foreach($this->nCategory as $key => $value){
            foreach($value as $k => $v){
                if(array_key_exists($v['id'], $this->nCategory)){
                    $this->nCategory[$key][$k]['nodes'] = $this->nCategory[$v['id']];
                    unset($this->nCategory[$v['id']]);
                }
            }
        }
        return $this->nCategory[0];
    }

    public function categorySetup(CategoryController $category, $id){
        $company = Company::findOrFail($id);
        $categories = $this->getAllCategoris();

        $currentCompanyCategories = $category->getCompanyCategorySorted($id);
        $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);

        return view('category.category_setup')->with('categories', $categories)->with('company', $company)->with('category', json_encode($currentCompanyCategoriesSorted));
    }

    public function getCompanyActiveCategory($categoriId){
        $this->category[] = Category::find($categoriId[0])->toArray();
        $parentId = $this->category[0]['parent_id'];
        if($parentId != 0){
            do{
                $current = Category::find($parentId)->toArray();
                $parentId = $current['parent_id'];
                $this->category[] = $current;
            }while($parentId != 0);
            foreach($this->category as $value){
                $value['text'] = $value['title'];
                $value['href'] = $value['id'];
                $value['nodes'] = array();
                $this->nCategory[$value['parent_id']][] = $value;
            }
            ksort($this->nCategory);
        }else{
            $this->nCategory[$this->category[0]['parent_id']] = $this->category;
        }
        return $this->nCategory;
    }

    public function getCompanyCategorySorted($companyId){
        $company = Company::find($companyId);
        return $company->getCategoryCompany->toArray();
    }

    public function treeBuilder(array $category){
        if(!count($category)){
            return [ ];
        }
        $this->category = array();
        $i = 0;
        foreach($category as $value){
            $parentId = $value['parent_id'];
            if(!$this->checkCat($value['id'], $this->category)){
                continue;
            }
            $this->category[] = $value;
            if($parentId != 0){
                do{
                    if($i == 4){
                    }
                    $current = Category::find($parentId)->toArray();

                    $parentId = $current['parent_id'];
                    if(!$this->checkCat($current['id'], $this->category)){
                        break;
                    }
                    $this->category[] = $current;
                }while($parentId != 0);
            }
            $i++;
        }
        foreach($this->category as $value){
            $value['text'] = $value['title'];
            $value['href'] = $value['id'];
            $value['nodes'] = array();
            $this->nCategory[$value['parent_id']][] = $value;
        }
        ksort($this->nCategory);
        $this->nCategory = array_reverse($this->nCategory, true);
        foreach($this->nCategory as $key => $value){
            foreach($value as $k => $v){
                if(array_key_exists($v['id'], $this->nCategory)){
                    $this->nCategory[$key][$k]['nodes'] = $this->nCategory[$v['id']];
                    unset($this->nCategory[$v['id']]);
                }
            }
        }
        return $this->nCategory[0];
    }

    public function findByCategory($id, CategoryController $category){

        $data = Product::where('category_id', $id)->paginate(1);

        $vip_category = Category::where('parent_id', $id)->get();


        return view('category.findByCategory')->with('data', $data)->with('category' ,$category->getAllCategoris())->with('vip_category', $vip_category);
    }

    public function attachCategoriesToCompany(Request $request, CategoryController $category){
        $this->validate($request, [
            'company'    => 'required',
            'categories' => 'required',

        ]);
        $company = Company::find($request->input('company'));
        $myCategories = $company->getCategoryCompany()->lists('id')->toArray();
        $newCategories = $request->input('categories');

        $company->getCategoryCompany()->detach($myCategories);
        $company->getCategoryCompany()->attach(array_unique(array_merge($myCategories, $newCategories)));

        $currentCompanyCategories = $category->getCompanyCategorySorted($request->input('company'));
        $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);

        return response()->json([ 'categories' => $currentCompanyCategoriesSorted ], 200);
    }

    public function detachCategoriesToCompany(Request $request, CategoryController $category){
        $this->validate($request, [
            'company'    => 'required',
            'categories' => 'required',
        ]);
        
        $company = Company::find($request->input('company'));
        $company->getCategoryCompany()->detach($request->input('categories'));
        $currentCompanyCategories = $category->getCompanyCategorySorted($request->input('company'));
        $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);

        return response()->json([ 'categories' => $currentCompanyCategoriesSorted ], 200);
    }
}