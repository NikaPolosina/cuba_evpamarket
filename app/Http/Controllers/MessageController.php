<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller{

    protected $_msg;
    protected $_msgModel;
    protected $_request;

    public function __construct(Message $message, Request $request){
        $this->_msgModel = $message;
        $this->_request = $request;
    }

    /**
     * Get current message
     *
     * @return Message
     */
    public function getMsg(){
        return $this->_msg;
    }

    /**
     * Set msg param
     *
     * @param Message $msg
     */
    public function setMsg(Message $msg){
        $this->_msg = $msg;
    }

    /**
     * Get Msg model
     *
     * @return Message
     * */
    public function getModel(){
        return new $this->_msgModel;
    }

    /**
     * Get single param
     *
     * @param string $param
     *
     * @return void
     */
    public function getMsgParam($param){
        return $this->_msg->$param;
    }

    /**
     * Set msg param
     *
     * @param string $param
     * @param string $value
     */
    public function setMsgParam($param, $value){
        $this->_msg->$param = $value;
    }

    /**
     * Save msg
     * */
    public function sendMsg(){
        $this->_msg->save();
    }

    /**
     * Get group invite
     *
     * @param User  $user
     * @param array $param
     * */
    public function getGroupInvite(User $user, array $param){
        $this->_msg = $this->_msgModel->where('to', $user->id)->where('status', $param['status'])->groupBy('connected_id')->with('group')->get();
    }

    /**
     * Check if item exists
     * */
    public function checkExists($id){
        $this->_request->request->add([ 'item' => $id ]);
        $this->validate($this->_request, [
            'item' => 'requered|exists:messages,id'
        ]);
    }

    /**
     * Get single msg
     * */
    public function singleMsg($id){
        $this->_msg = $this->getModel()->find($id);
    }

    /**
     * Set msg as readed
     * */
    public function setAsReaded(){
        $this->_msg->status = 1;
        $this->_msg->save();

    }
}