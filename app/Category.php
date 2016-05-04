<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Product;



class Category extends Authenticatable{

    protected $table = 'category';
    protected $fillable = ['parent_id', 'title'];

    public function giveProduct(){
        return $this->belongsTo('App\Product', 'category_id', 'id');
    }
}
?>