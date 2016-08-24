<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model{

    protected $table = 'messages';

    /**
     * relationship between user and messages
     * */
    public function userMessages(){
        return $this->hasOne('App\User');
    }

    /**
     * relationship between messages and group
     * */
    public function group(){
        return $this->hasOne('App\Group', 'id', 'connected_id');
    }

}
