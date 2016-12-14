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
use Creitive\Breadcrumbs\Breadcrumbs;

class CategoryController extends Controller{
    protected $_breadcrumbs;

    public function __construct(Request $request,  Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
        $this->_breadcrumbs->setDivider('<img style="display: inline-block;  height: 37px;" src="/img/system/next-bread.png">');
    }

    public function checkCat($search, $arr){
        foreach($arr as $value){
            if($search == $value['id']){
                return false;
            }
        }
        return true;
    }
    
    //Метод который подготавливает и сортирует от родительськой категории до дочерней все катигории записанные в базе данных.
    public function getAllCategoris(){
        $category = Category::all()->toArray();//Достаем массив всех категорий.
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
                if(!count($nCategory[$key][$k]['nodes'])){
                    $nCategory[$key][$k]['nodes'] = null;
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

        $company = Company::find($id);


        $this->_breadcrumbs->addCrumb('Домой', '/login-user');
        $this->_breadcrumbs->addCrumb('Магазин - '.$company->company_name, '/product-editor/'.$company->id);
        $this->_breadcrumbs->addCrumb('Установка категорий', '/category/category-setup/'.$company->id);
        
        return view('category.category_setup')
            ->with('categories', $categories)
            ->with('default_company_categories', json_encode($company->getCategoryCompany()->get()->lists('id')))
            ->with('company', $company)
            ->with('category', json_encode($currentCompanyCategoriesSorted))
            ->with('breadcrumbs', $this->_breadcrumbs);
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
                if(!count($this->nCategory[$key][$k]['nodes'])){
                    $this->nCategory[$key][$k]['nodes'] = null;
                }
            }
        }
        return $this->nCategory[0];
    }

    public function attachCategoriesToCompany(Request $request, CategoryController $category){
        /*        $this->validate($request, [
                    'company'    => 'required',
                    'categories' => 'required',
                ]);
                $myCategories = $company->getCategoryCompany()->lists('id')->toArray();
                $newCategories = $request->input('categories');

                $company->getCategoryCompany()->detach($myCategories);
                $company->getCategoryCompany()->attach(array_unique(array_merge($myCategories, $newCategories)));

                $currentCompanyCategories = $category->getCompanyCategorySorted($request->input('company'));
                $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);
        */
        $this->validate($request, [
            'company'    => 'required',
        ]);

        $company = Company::find($request->input('company'));
        $company->getCategoryCompany()->detach([]);

        if(count($request->input('categories'))){
            $company->getCategoryCompany()->attach($request->input('categories'));
        }

        $currentCompanyCategories = $category->getCompanyCategorySorted($request->input('company'));
        $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);

        return response()->json([ 'categories' => $currentCompanyCategoriesSorted ], 200);
    }


    public function attachCategoriesToCompanyTwo(Request $request, CategoryController $category){

        $currentCompanyCategoriesSorted = array();
        if(count($request->input('categories'))){
            $categories = array_unique($request->input('categories'));
            $currentCompanyCategories = Category::whereIn('id', $categories)->get()->toArray();
            $currentCompanyCategoriesSorted = $category->treeBuilder($currentCompanyCategories);
        }

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

    /*
     * Метод для получения всех дополнительных праметров товаров прикрепленных к данной категории. Передаем $id.
     * */
    public function getAddParamFromCategory($id, Request $request){
        $value = array();
        if($request->has('value')){
            $value = json_decode($request->input('value'), true);
        }

        $addParam = Category::where('id',$id)->with(['getAddParam'=>function($query){
            $query->orderBy('sort')->get();
        }])->first();
        

        foreach($addParam->getAddParam as $item){
            $item->value = json_decode($item->value, true);
        }


                //$product = Product::find(7);
                //$value = json_decode($product->value, true);

        return view('product.additionParam')->with('addParam', $addParam->getAddParam)->with('value', $value);

    }
}