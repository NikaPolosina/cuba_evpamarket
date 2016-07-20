<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model{
    protected $table = 'product_order';
    protected $fillable = [ 'product_id', 'cnt', 'price', 'order_id'];

    public function getProductOrder(){
        return $this->hasOne('App\Order', 'id', 'order_id');
    }
    public function getProductId(){
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
