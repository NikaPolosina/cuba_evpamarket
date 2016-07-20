<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusOwner extends Model{

    protected $table = 'status_owner';
    protected $fillable = [ 'title', 'status_simple_id'];

    public function getStatusSiple(){
        return $this->hasOne('App\StatusSimple', 'id', 'status_simple_id');
    }

    public function giveOrder(){
        return $this->belongsTo('App\Order', 'order', 'id');
    }
}
