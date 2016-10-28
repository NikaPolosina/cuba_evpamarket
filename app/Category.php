<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Product;

class Category extends Authenticatable{

    protected $table = 'category';
    protected $fillable = [
        'parent_id',
        'title'
    ];

    public function giveProduct(){
        return $this->belongsTo('App\Product', 'category_id', 'id');
    }

    public function getAddParam(){
        return $this->belongsToMany('App\AdditionParam', 'additional_param_category', 'category_id', 'additional_param_id');
    }
}

?>