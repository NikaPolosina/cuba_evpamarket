<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Nicolaslopezj\Searchable\SearchableTrait;


class UserInformation extends Authenticatable
{
    use EntrustUserTrait;
    use SearchableTrait;

    protected $table = 'user_informations';
    protected $fillable = [ 'name', 'surname', 'date_birth', 'gender', 'location', ];



}