<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMoney extends Model{
    protected $table = 'user_money';
    protected $fillable = [ 'user_id', 'company_id', 'money'];

    public function getUser(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function getCompany(){
        return $this->hasOne('App\Company', 'id', 'company_id');
    }
}
