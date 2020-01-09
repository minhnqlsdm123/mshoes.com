<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    protected $fillable = ['product_id', 'size_id', 'quantity'];

    protected $table = 'product_details';

    public function product()
    {
    	return $this->belongsToMany('App\Product', 'product_id');
    	// return $this->belongsTo('App\Product', 'product_id');
    }
    

}
