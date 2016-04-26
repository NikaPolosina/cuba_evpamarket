<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model{

    protected $table = 'companies';

    protected $fillable = ['company_name', 'company_description', 'company_logo', 'company_content', 'company_address', 'company_contact_info', 'company_additional_info'];

    public function getProducts(){
        return $this->belongsToMany('App\Product');

    }

}
