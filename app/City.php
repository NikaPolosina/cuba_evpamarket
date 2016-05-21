<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;



class City extends Authenticatable{

    protected $table = 'cities';
    protected $fillable = [ 'id_cities', 'title_cities', 'region_id',];
}
    ?>