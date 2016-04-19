<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $table = 'user_company';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'company_id'
    ];
}
