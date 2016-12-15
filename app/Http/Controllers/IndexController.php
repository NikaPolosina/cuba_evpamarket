<?php
namespace App\Http\Controllers;

use App\Category;
use App\ChatUsers;
use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use League\Flysystem\Exception;
use Session;
use App\Company;
use Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use Creitive\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Artisan;

use App\ChatMsgs;
use App\User;
class IndexController extends Controller{
    public function test(MessageController $mesage){
        return view('test_s');
    }
    /**
     * Get products image
     *
     * @param object $arr
     *
     * @return array
     * */
    //Метод который отвечает за проверку наличия картинки (файла по данному товару) принимает колекцию товаров.
    public static function showProduct($arr){
        if($arr instanceof Product){
            $arr = self::getProductImg($arr);
        }else{
            foreach($arr as $v){
                $idProduct = $v['id'];
                $idCompany = $v->getCompany[0]['id'];
                $directory = public_path().'/img/custom/companies/'.$idCompany.'/products/'.$idProduct;
                $directoryMy = '/img/custom/companies/'.$idCompany.'/products/'.$idProduct.'/';
                if(!empty($v['product_image']) && File::exists($directory.'/'.$v['product_image'])){
                    $v->firstFile = $directoryMy.$v['product_image'];
                }else{
                    if(is_dir($directory)){
                        $files = scandir($directory);
                        $v->firstFile = $directoryMy.$files[2];
                        if(is_dir(public_path().$v->firstFile)){
                            if(isset($files[3])){
                                $v->firstFile = $directoryMy.$files[3];
                            }else{
                                $v->firstFile = '/img/custom/files/thumbnail/plase.jpg';
                            }
                        }
                    }else{
                        $v->firstFile = '/img/custom/files/thumbnail/plase.jpg';
                    }
                }
            }
        }
        return $arr;
    }
    /**
     * Get single product image
     *
     * @param object $v Instance of model class
     *
     * @return Product
     * */
    private static function getProductImg(Product $product){
        $idProduct = $product['id'];
        $idCompany = $product->getCompany[0]['id'];
        $directory = public_path().'/img/custom/companies/'.$idCompany.'/products/'.$idProduct;
        $directoryMy = '/img/custom/companies/'.$idCompany.'/products/'.$idProduct.'/';
        if(!empty($product['product_image']) && File::exists($directory.'/'.$product['product_image'])){
            $product->firstFile = $directoryMy.$product['product_image'];
        }else{
            if(is_dir($directory)){
                $files = scandir($directory);
                $product->firstFile = $directoryMy.$files[2];
                if(is_dir(public_path().$product->firstFile)){
                    if(isset($files[3])){
                        $product->firstFile = $directoryMy.$files[3];
                    }else{
                        $product->firstFile = '/img/custom/files/thumbnail/plase.jpg';
                    }
                }
            }else{
                $product->firstFile = '/img/custom/files/thumbnail/plase.jpg';
            }
        }
        return $product;
    }

    //Метод (входная точка сайта, для отрисовки титульной страницы сайта.)
    public function Index(ProductsController $product, CompanyController $company, CategoryController $category, Request $request){
        $productAll = Product::where('status_product', 'active')->paginate(8);//достаем с баы данных все товары у которых статус (status_product == active), тоесть активен (active) и ставим пагинацию.
        $companyAll = $company->getCompanyAll(); //Берем с юазы данных все компании.
        foreach($companyAll['companyAll'] as $value){
            $value->company_logo = $company->showCompanyLogo($value->id);
        }
        $dir = 'images/large';
        $vip_category = Category::where('vip', 1)->get();
        $slide_img = array_diff(scandir($dir), array(
            '..',
            '.'
        ));
        $this->showProduct($productAll);
        $this->addFeedProduct($productAll);

        return view('welcome')->with('productAll', $productAll)->with('companyAll', $companyAll['companyAll'])->with('slide_img', $slide_img)->with('category', $category->getAllCategoris())->with('vip_category', $vip_category);
    }

    public function addFeedProduct($productAll){
        foreach($productAll as $product){
            $product->raiting = 0;
            $product->count = $product->getFeedback->count();
            if($product->count){
                $product->raiting = (($product->getFeedback()->sum('rating') / $product->count) * 100) / 5;
            }
        }
        return $productAll;
    }

    public function whoAmI($id){
        $user = User::find($id);
        if($user){
            return response()->json($user, 200);
        }else{
            return response()->json([ 'msg' => 'Auth Error' ], 422);
        }
    }

    public function saveChat(Request $request, ChatMsgs $chatMsgs){
        $this->validate($request,[
            'from_id'      => 'required',
            'to_id'        => 'required|exists:users,id',
            'body'         => 'required',
            'chat_user_id' => 'required|exists:chat_users,id'
        ]);
    
        $r = $chatMsgs->create([
            'from_id'      => $request->from_id,
            'to_id'        => $request->to_id,
            'body'         => $request->body,
            'chat_user_id' => $request->chat_user_id
        ]);

        try{
            ChatUsers::where('id', $request->chat_user_id)->update(['updated_at' => Carbon::now()]);
        }catch(\Exception $e){
        }

        return response()->json([ 'success' => $r->toArray() ], 200);
    }

    public function chatHistory(ChatController $chatController, $conversation, $page){
        try{
            return response()->json($chatController->getHistory($conversation, $page), 200);
        }catch(\Exception $e){
            return response()->json([ 'errors' => $e->getMessage() ], 422);
        }
    }
}