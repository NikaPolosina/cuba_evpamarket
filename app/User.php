<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Nicolaslopezj\Searchable\SearchableTrait;


class User extends Authenticatable
{
    use EntrustUserTrait;
    use SearchableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [ 'email', 'phone', 'password', ];

    public function getUserInfo(){
        return $this->select('email', 'phone')->get();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getCompanies(){
        return $this->belongsToMany('App\Company');
    }
    public function getProduct(){
        return $this->belongsToMany('App\Product');
    }


    public function getUserInformation(){
        return $this->hasOne('App\UserInformation');
    }

}
