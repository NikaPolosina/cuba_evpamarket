<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;



class Category extends Authenticatable{

    protected $table = 'category';
    protected $fillable = [ 'parent_id', 'title'];
}
?>