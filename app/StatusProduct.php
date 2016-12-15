<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusProduct extends Model{
    protected $table = 'status_product';
    protected $fillable = [ 'status_key', 'status_name', 'visible_admin', 'visible_seller', 'visible_buyer'];

    public function getProduct(){
        return $this->hasOne('App\Product', 'id', 'status_product_id');
    }
    
}
