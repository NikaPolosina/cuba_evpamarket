<?php

namespace App;
use App\Category;
use App\DiscountAccumulativ;
use App\ChatMsgs;

use Illuminate\Database\Eloquent\Model;

class ChatUsers extends Model{

    protected $table = 'chat_users';

    protected $fillable = ['from_id', 'to_id', 'type'];

    public function getUserFrom(){
        return $this->hasOne('App\User', 'from_id', 'id');

    }
    public function getUserTo(){
        return $this->hasOne('App\User', 'to_id', 'id');

    }

    public function getChatMsgs(){
        return $this->hasMany('App\ChatMsgs', 'chat_user_id', 'id');
    }




}
