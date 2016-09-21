<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackProduct extends Model{
    protected $table = 'feedback_product';
    protected $fillable = [ 'order_id', 'product_id', 'user_id', 'feedback', 'rating', 'file'];

    public function getProduct(){
        return $this->hasMany('App\Product', 'product_id', 'id');
    }
    public function getUser(){
        return $this->hasOne('App\User','id', 'user_id');
    }
    public function getOrder(){
        return $this->hasMany('App\Order', 'order_id', 'id');
    }

}
