<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionFeed extends Model{
    protected $table = 'addition_feedback';
    protected $fillable = ['feed_id', 'msg'];

    public function getFeed(){
        return $this->hasMany('App\FeedbackProduct', 'feed_id', 'id');
    }


}