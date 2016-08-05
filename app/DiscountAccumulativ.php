<?php

namespace App;
use App\Company;
use Illuminate\Database\Eloquent\Model;

class DiscountAccumulativ extends Model{
    protected $table = 'discount_accumulative';
    protected $fillable = ['from', 'percent', 'company_id'];


    public function getCompany(){
        return $this->hasOne('App\Company');
    }


}
