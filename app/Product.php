<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
    use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
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
    protected $fillable = ['product_id', 'category_id', 'product_description', 'product_image', 'product_price'];

    public function getCompany(){
        return $this->belongsToMany('App\Company');

    }

    protected $searchable = [ 'columns' => ['product_description' => 5,],];


}
