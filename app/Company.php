<?php

namespace App;
use App\Category;
use App\DiscountAccumulativ;

use Illuminate\Database\Eloquent\Model;

class Company extends Model{

    protected $table = 'companies';

    protected $fillable = ['company_name', 'company_description', 'company_logo', 'company_content', 'country', 'region_id','city_id','street', 'address', 'company_contact_info', 'company_additional_info', 'block'];

    public function getProducts(){
        return $this->belongsToMany('App\Product');

    }
    public function getCategoryCompany(){
        return $this->belongsToMany('App\Category');
    }
    public function getUser(){
        return $this->belongsToMany('App\User');
    }

    public function getOrder(){
        return $this->belongsToMany('App\Order');
    }
    public function getUserMoney(){
        return $this->hasMany('App\UserMoney');
    }

    public function getDiscountAccumulativ(){
        return $this->hasMany('App\DiscountAccumulativ');
    }
    


}
