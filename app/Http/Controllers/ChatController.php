<?php
/**
 * Created by PhpStorm.
 * User: HP630
 * Date: 06.10.2016
 * Time: 14:39
 */
namespace App\Http\Controllers;


use App\User;
//use App\Chat;

class ChatController{
    public $user;
    
    public function __construct(){ 
        $this->user = new User();
    }

    public function loginUser($id, $email){
        return $this->user->where('id', $id)->where('email', $email)->first()->toArray();
   }
    
    public function getHistory(){
        return array();
    }
    
    public function sendMsg($id, $data){
        //        
    }

}