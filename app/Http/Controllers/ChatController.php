<?php
/**
 * Created by PhpStorm.
 * User: HP630
 * Date: 06.10.2016
 * Time: 14:39
 */
namespace App\Http\Controllers;

use App\User;
use App\ChatMsgs;

class ChatController{

    public $user;
    public $chat;

    /**
     * Init
     * */
    public function initDependency(){
        $this->user = new User();
        $this->chat = new ChatMsgs();
    }

    /**
     * Login action
     * */
    public function loginUser($id, $email){
        $this->initDependency();
        return $this->user->where('id', $id)->where('email', $email)->first()->toArray();
    }

    /**
     * Get history of conversation
     * */
    public function getHistory($id, $connectedId){
        $this->initDependency();
        return array();
        // uncoment if need send history of converation
        //return $this->chat->where('chat_user_id', $connectedId)->get()->toArray();
    }

    /**
     * Save history to db
     * */
    public function sendMsg($id, $data){
        $this->initDependency();
        $this->chat->from_id = $id;
        $this->chat->to_id = $data->to;
        $this->chat->body = $data->msg;
        $this->chat->chat_user_id = $data->connected_id;
        $this->chat->save();
        $this->chat->getChatId()->touch();
    }
}