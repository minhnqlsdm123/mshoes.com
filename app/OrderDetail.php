<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	protected $fillable = ['order_id', 'product_detail_id', 'quantity'];

	protected $table = 'order_details';
}
