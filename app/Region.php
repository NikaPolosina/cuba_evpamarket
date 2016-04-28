<?php

namespace App;
use App\City;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Region extends Authenticatable{
    protected $table    = 'regions';
    protected $fillable = [ 'title', 'id_region' ];
    public function getCities(){
        return $this->hasMany('App\City');
    }
}