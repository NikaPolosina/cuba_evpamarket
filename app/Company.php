<?php

namespace App;
use App\Category;

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

}
