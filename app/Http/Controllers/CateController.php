<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CateRequest;
use App\Cate;

class CateController extends Controller
{
    public function getAdd ()
    {
        $parent = Cate::select('id', 'name', 'parent_id')->get()->toArray();
        return view('admin.cate.add', compact('parent'));
    }

    public function postAdd (CateRequest $request)
    {
        $cate = new Cate();

        $cate->name         = $request->txtCateName;
        $cate->alias        = convert_vi_to_en($request->txtCateName);
        $cate->order        = $request->txtOrder;
        $cate->parent_id    = $request->sltParent;
        $cate->keywords     = $request->txtKeywords;
        $cate->description  = $request->txtDescription;
        $cate->Save();
        return redirect()->route('admin.cate.list')->with(['flash_level' => 'success','flash_message' => 'Success!! Complete add category']);
    }

    public function getList()
    {
        return view('admin.cate.list');
    }
}
