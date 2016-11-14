<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{

    protected $table = 'order';
    protected $fillable = [ 'simple_user_id', 'owner_user_id', 'status', 'total_price', 'discount_price', 'percent',  'order_phone', 'region', 'note', 'city', 'street', 'address', 'name', 'surname'];

    public function getStatusOwner(){
        return $this->hasOne('App\StatusOwner', 'id', 'status');
    }
    public function getSimpleOrder(){
        return $this->hasOne('App\User', 'id', 'simple_user_id');
    }
    public function getSOwnerOrder(){
        return $this->hasOne('App\User', 'id', 'owner_user_id');
    }
    public function getProductOrder(){
        return $this->hasMany('App\ProductOrder', 'order_id', 'id');
    }
    public function getCompany(){
        return $this->belongsToMany('App\Company');
    }
    public function getFeedback(){
        return $this->hasMany('App\FeedbackProduct', 'order_id', 'id');
    }
}
