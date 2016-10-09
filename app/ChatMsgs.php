<?php

namespace App;

use App\Category;
use App\DiscountAccumulativ;

use Illuminate\Database\Eloquent\Model;

class ChatMsgs extends Model{

    protected $table = 'chat_msgs';

    protected $fillable = [
        'from_id',
        'to_id',
        'body',
        'chat_user_id'
    ];

    public function getUserFrom(){
        return $this->hasOne('App\User', 'id', 'from_id');
    }

    public function getUserTo(){
        return $this->hasOne('App\User', 'id', 'to_id');
    }

    public function getChatId(){
        return $this->hasOne('App\ChatUsers', 'id', 'chat_user_id');
    }
}
