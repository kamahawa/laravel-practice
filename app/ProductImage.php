<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
	protected $table = 'product_images';

	protected $fillable = ['image', 'product_id'];

	public $timestamp = false;

	//ket noi product_images table vs products table
	public function product()
	{
		//1 image thuoc 1 san pham
		return $this->belongsTo('App\Prodct');
	}
}
