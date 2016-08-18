<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model{

    protected $table = 'groups';
    protected $fillable = [ 'company_id', 'group_name', 'money'];
    
    public function getCompany(){
        return $this->hasOne('App\Company', 'id', 'company_id');
    }

    public function getUser(){
        return $this->belongsToMany('App\User')->withPivot('is_admin');
    }
}
