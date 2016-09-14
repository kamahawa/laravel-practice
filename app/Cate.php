<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
	protected $table = 'cates';

	protected $fillable = [
		'name', 'alias', 'order', 'parent_id', 'keywords', 'description',
	];

	public $timestamp = false;

	//ket noi cates table vs products table
	public function product()
	{
		//1 category chua nhieu san pham
		return $this->hasMany('App\Prodct');
	}
}
