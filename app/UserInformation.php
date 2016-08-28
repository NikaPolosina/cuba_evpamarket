<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserInformation extends Authenticatable{

    use EntrustUserTrait;
    use SearchableTrait;
    protected $table = 'user_informations';
    protected $fillable = [
        'name',
        'surname',
        'avatar',
        'date_birth',
        'gender',
        'country',
        'region_id',
        'city_id',
        'street',
        'address',
        'about_me',
        'my_site'
    ];

    /**
     * Declare date fields
     * */
    public function getDates(){
        return [
            'created_at',
            'updated_at',
            'date_birth'
        ];
    }

    public function getUser(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}