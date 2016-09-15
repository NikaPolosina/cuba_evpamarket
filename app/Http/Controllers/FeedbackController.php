<?php

namespace App\Http\Controllers;

use App\Category;
use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Company;
use Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use Creitive\Breadcrumbs\Breadcrumbs;

class FeedbackController extends Controller{
    protected $_breadcrumbs;
    
    public function __construct(Request $request, Breadcrumbs $breadcrumbs){
        $this->_breadcrumbs = $breadcrumbs;
    }

    public function start(){
        die('Surprise, you are here !!!');

    }

}