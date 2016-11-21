<?php

namespace App;

use App\Category;
use App\DiscountAccumulativ;

use Illuminate\Database\Eloquent\Model;

class AdditionParam extends Model{

    protected $table = 'additional_param';

    protected $fillable = ['title', 'description', 'placeholder', 'type', 'required', 'request', 'request_buyer', 'sort', 'default', 'value'];
    
}


