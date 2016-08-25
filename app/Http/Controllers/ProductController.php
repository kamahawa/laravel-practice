<?php

namespace App\Http\Controllers;

use App\Cate;
use App\Product;
use App\ProductImage;
use File;
use Request;
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

        $product_id = $product->id;
        if($request->hasFile('fProductDetail'))
        {
            foreach($request->file('fProductDetail') as $file)
            {
                $product_img = new ProductImage();
                if(isset($file))
                {
                    $product_img->image = $file->getClientOriginalName();
                    $product_img->product_id = $product_id;
                    $file->move('resources/upload/detail/',$file->getClientOriginalName());
                    $product_img->save();
                }
            }
        }
        return redirect()->route('admin.product.list')->with(['flash_level' => 'success','flash_message' => 'Success!! Complete add product']);
    }

    public function getList()
    {
        $data = Product::select('id', 'name', 'price', 'cate_id', 'created_at')->orderBy('id', 'DESC')->get()->toArray();
        return view('admin.product.list', compact('data'));
    }

    public function getDelete($id)
    {
        $product_detail = Product::find($id)->pimage->toArray();

        foreach($product_detail as $value)
        {
            File::delete('resources/upload/detail/'.$value['image']);
        }
        $product = Product::find($id);
        File::delete('resources/upload/'.$product->image);
        $product->delete($id);
        return redirect()->route('admin.product.list')->with(['flash_level' => 'success','flash_message' => 'Success!! Complete delete product']);
    }

    public function getEdit($id)
    {
        $cate = Cate::select('id', 'name', 'parent_id')->get()->toArray();
        $product = Product::find($id);
        $product_image = Product::find($id)->pimage;
        return view('admin.product.edit', compact('cate', 'product', 'product_image'));
    }

    public function postEdit($id)
    {

    }

    public function getDelImg($id)
    {
        if(Request::ajax())
        {
            $idHinh = (int)Request::get('idHinh');
            $image_detail = ProductImage::find($idHinh);
            if(!empty($image_detail))
            {
                $img = 'resources/upload/detail/'.$image_detail->image;
                if(File::exists($img))
                {
                    File::delete($img);
                }
                $image_detail->delete();
            }
            return 'Ok';
        }
    }
}
