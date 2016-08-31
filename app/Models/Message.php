<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model{

    protected $table = 'messages';
    protected $fillable = [ 'type', 'connected_id', 'status', 'from', 'to', 'subject', 'body'];

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
