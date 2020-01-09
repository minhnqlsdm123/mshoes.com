<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{	
	protected $table='products';

    protected $fillable=['name','origin_price','sale_price','description','content','slug','color_id','brand_id','provider_id','category_id'];

    public function galleryImages(){
    	return $this->hasMany('App\GalleryImage');
    }

    public function brand(){
    	return $this->belongsTo('App\Brand');
    }
     public function category(){
    	return $this->belongsTo('App\Category');
    }
    public function color(){
        return $this->belongsTo('App\Color');
    }

    // public function product_detail()
    // {
    //  return $this->hasMany('App\ProductDetails', 'product_id', 'id');
    // }

}
