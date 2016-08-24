<?php

namespace App\Http\Controllers;

use App\Cate;
use Illuminate\Http\Request;

use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function getAdd ()
    {
        $cate = Cate::select('id', 'name', 'parent_id')->get()->toArray();
        return view('admin.product.add', compact('cate'));
    }

    public function postAdd (ProductRequest $request)
    {
        
    }
}
