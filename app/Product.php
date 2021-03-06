<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\StatusProduct;

class Product extends Model{

    use SearchableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'category_id',
        'product_description',
        'content',
        'product_image',
        'product_price',
        'min_price',
        'max_price',
        'value',
        'status_product'
    ];

    public function getCompany(){
        return $this->belongsToMany('App\Company');
    }

    public function getCategory(){
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function getFeedback(){
        return $this->hasMany('App\FeedbackProduct', 'product_id', 'id');
    }  
    public function getStatusProduct(){
        return $this->hasOne('App\StatusProduct', 'status_key', 'status_product');
    }

    protected $searchable = [ 'columns' => [ 'product_name' => 5, ], ];
}
