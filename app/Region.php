<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Region extends Authenticatable{
    protected $table    = 'regions';
    protected $fillable = [ 'title' ];
}