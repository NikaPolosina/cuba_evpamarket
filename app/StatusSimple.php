<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusSimple extends Model{

    protected $table = 'status_simple';
    protected $fillable = [ 'title'];
    
    public function giveStatus(){
        return $this->belongsTo('App\StatusOwner', 'status_simple_id', 'id');
    }
}
