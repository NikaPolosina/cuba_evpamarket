<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberGroupHistory extends Model{

    protected $table = 'member_group_history';

    protected $fillable = ['user_id', 'group_id', 'money'];

    public function getUser(){
        return $this->belongsToMany('App\User');
    }
    public function getGroup(){
        return $this->belongsToMany('App\Group');
    }





}