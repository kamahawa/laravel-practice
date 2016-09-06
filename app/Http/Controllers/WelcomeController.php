<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WelcomeController extends Controller
{
    public function index()
    {
        $product = DB::table('products')->select('id','name','image','price','alias')->orderBy('id','DESC')->skip(0)->take(4)->get();
        return view('user.pages.home', compact('product'));
    }

    public function loaisanpham($id)
    {
        //$product_cate = DB::table('products')->select('id','name','image','price','alias','cate_id')->where('cate_id',$id)->get();
        $product_cate = DB::table('products')->select('id','name','image','price','alias','cate_id')->where('cate_id',$id)->paginate(1);
        $cate = DB::table('cates')->select('parent_id')->where('id', $product_cate[0]->cate_id)->first();
        $menu_cate = DB::table('cates')->select('id','name','alias')->where('parent_id',$cate->parent_id)->get();
        $name_cate = DB::table('cates')->select('name')->where('id',$id)->first();
        $lated_product = DB::table('products')->select('id','name','image','price','alias','cate_id')->orderBy('id','DESC')->take(3)->get();
        return view('user.pages.cate', compact('product_cate', 'menu_cate', 'lated_product', 'name_cate'));
    }

    public function chitietsanpham($id)
    {
        $product_detail = DB::table('products')->where('id', $id)->first();
        $image = DB::table('product_images')->select('id','image')->where('product_id',$product_detail->id)->get();
        $product_cate = DB::table('products')->where('cate_id', $product_detail->cate_id)->where('id', '<>', $product_detail->id)->take(4)->get();
        return view('user.pages.detail', compact('product_detail', 'image', 'product_cate'));
    }

    public function getLienHe()
    {
        return view('user.pages.contact');
    }

    public function postLienHe(Request $request)
    {
        $data = ['hoten' => $request->name, 'msg' => $request->message];
        Mail::send('emails.blanks', $data, function($msg){
            $msg->from('checker.tester00@gmail.com', 'tester 00');
            $msg->to('checker.tester01@gmail.com', 'tester 01')->subject('Day la mail test');
        });
    }

    public function muahang($id)
    {
        $product_buy = DB::table('products')->where('id', $id)->first();
        Cart::add(['id'=> $id, 'name' => $product_buy->name, 'qty' => 1, 'price' => $product_buy->price, 'options' => ['img' => $product_buy->image]])->setTaxRate(0);

        return redirect()->route('giohang');
    }

    public function giohang()
    {
        $content = Cart::content();
        $total = Cart::total();

        return view('user.pages.shopping', compact('content', 'total'));
    }
}
