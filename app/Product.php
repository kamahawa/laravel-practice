<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $fillable = [
		'name', 'alias', 'price', 'intro', 'content', 'image', 'keywords', 'description', 'user_id', 'cate_id',
	];

	public $timestamp = false;

	// lien ket products table vs bang cates table
	public function cate()
	{
		//1 san pham thi thuoc 1 category
		return $this->belongsTo('App\Cate');
	}

	// lien ket products table vs users table
	public function user()
	{
		//1 san pham thi thuoc 1 user
		return $this->belongsTo('App\User');
	}

	//lien ket products table vs product_images table
	public function pimage()
	{
		//1 san pham co nhieu image
		return $this->hasMany('App\ProductImage');
	}
}
