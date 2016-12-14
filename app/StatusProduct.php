<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusProduct extends Model{
    protected $table = 'status_product';
    protected $fillable = [ 'status_key', 'status_name'];

    public function getProduct(){
        return $this->hasOne('App\Product', 'id', 'status_product_id');
    }
    
}
