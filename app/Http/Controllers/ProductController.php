<?php

namespace App\Http\Controllers;

use App\Cate;
use App\Product;
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
        $fileName = $request->file('fImages')->getClientOriginalName();
        $product = new Product();
        $product->name = $request->txtName;
        $product->alias = convert_vi_to_en($request->txtName);
        $product->price = $request->txtPrice;
        $product->intro = $request->txtIntro;
        $product->content = $request->txtContent;
        $product->image = $fileName;
        $product->keywords = $request->txtKeywords;
        $product->description = $request->txtDescription;
        $product->user_id = 1;
        $product->cate_id = $request->sltParent;
        $request->file('fImages')->move('resources/upload/',$fileName);
        $product->save();
    }
}
