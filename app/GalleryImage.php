<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
	protected $table='gallery_images';

	protected $fillable = ['product_id' ,'link'];

	 public function product()
    {
    	return $this->belongsToMany('App\Product', 'product_id'); 
    }
}
