<?php

namespace App\Classes\Socket;

use App\Classes\Socket\Base\BaseSocket;
use Ratchet\ConnectionInterface;
use App\Http\Controllers\ChatController;

class ChatSocket extends BaseSocket{

    protected $clients;
    protected $confirmed = array();
    protected $keys      = array();
    protected $_response = array();
    protected $_chatController;

    public function __construct(){
        $this->clients = new \SplObjectStorage;
        $this->_chatController = new ChatController();
        $this->_response = array();
    }

    public function onOpen(ConnectionInterface $conn){
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $data){
        //$this->_chatController->validateData(['to'=>'required'], $data);
        try{
            $this->_data = json_decode($data);
        }catch(\Exception $e){
            $this->_errorResponse($from, [ 'msd' => 'Wrong data type' ]);
        }

        $method = '_on'.ucfirst($this->_data->action);
        $this->_response = array();
        $this->_response['action'] = $this->_data->action;
        if(method_exists($this, $method)){
            $this->$method($from);
        }else{
            $this->_errorResponse($from, [ 'msg' => 'Event does not exists' ]);
        }
    }

    public function onClose(ConnectionInterface $conn){
        $this->_successResponse($conn);
        $this->clients->detach($conn);

        if(array_key_exists($conn->resourceId, $this->confirmed)){
            unset($this->confirmed[$conn->resourceId]);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
        $this->_errorResponse($conn, [ 'msg' => $e->getMessage() ]);
        $conn->close();
    }

    /**
     * Return success response
     * */
    private function _successResponse(ConnectionInterface $to, $data = false){
        $this->_response['success'] = true;
        $this->_prepareResponse($data);
        $this->_sendAction($to);
    }

    /**
     * Return error response
     * */
    private function _errorResponse(ConnectionInterface $to, $data){
        $this->_response['success'] = false;
        $this->_prepareResponse($data);
        $this->_sendAction($to);
    }

    /**
     * Prepare response data
     *
     * @param void $data
     * */
    private function _prepareResponse($data){
        switch(true){
            case is_array($data):
                $this->_response = array_merge($this->_response, $data);
                break;
            case is_string($data):
                $this->_response['msg'] = $data;
                break;
        }
    }

    /**
     * Send Action
     * */
    private function _sendAction($to){
        try{
            $to->send(json_encode($this->_response));
        }catch(\Exception $e){
            $to->send(json_encode($e->getMessage()));
        }
    }

    /**
     * Login user event
     * */
    private function _onLogin(ConnectionInterface $from){
        $user = $this->_chatController->loginUser($this->_data->id, $this->_data->email);
        if(!$user){
            $this->_errorResponse($from, [ 'msg' => 'User not found' ]);
        }else{
            $this->_response['chat'] = $this->_chatController->getHistory($user['id'], $this->_data->connected_id);
            if(!array_key_exists($from->resourceId, $this->confirmed)){
                $this->confirmed[$from->resourceId]['user'] = $user;
                $this->confirmed[$from->resourceId]['resource'] = $from;
                $this->keys[$user['id']] = $from->resourceId;
                $this->_successResponse($from, [ 'user' => $this->confirmed[$from->resourceId]['user'] ]);
            }else{
                $this->_successResponse($from, [
                    'user' => $this->confirmed[$from->resourceId]['user'],
                    'msg'  => 'You already in chat, how you do that ??? Cheater !'
                ]);
            }
        }
    }

    /**
     * User wrote message
     * */
    private function _onChat(ConnectionInterface $from){
        if(array_key_exists($from->resourceId, $this->confirmed)){
            $sender = $this->confirmed[$from->resourceId];
            if(array_key_exists($this->_data->to, $this->keys)){
                $getter = $this->confirmed[$this->keys[$this->_data->to]];
                $this->_successResponse($getter['resource'], [ 'msg' => $this->_data->msg ]);
            }
            $this->_chatController->sendMsg($sender['user']['id'], $this->_data);
            //$this->_successResponse($from, [ 'msg' => $this->_data->msg ]);
        }else{
            $this->_errorResponse($from, [ 'msg' => 'You should login first' ]);
        }
    }
}