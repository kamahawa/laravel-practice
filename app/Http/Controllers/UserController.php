<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
//use Illuminate\Foundation\Auth\User;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getList()
    {
        $user = User::select('id', 'username', 'level')->orderBy('id', 'DESC')->get()->toArray();
        return view('admin.user.list', compact('user'));
    }

    public function getAdd()
    {

        return view('admin.user.add');
    }

    public function postAdd(UserRequest $request)
    {
        $user = new User();
        $user->username = $request->txtUser;
        $user->password = Hash::make($request->txtPass);
        $user->email = $request->txtEmail;
        $user->level = $request->rdoLevel;
        $user->remember_token = $request->_token;
        $user->save();
        return redirect()->route('admin.user.list')->with(['flash_level' => 'success','flash_message' => 'Success!! Complete add user']);
    }

    public function getDelete()
    {

    }

    public function getEdit()
    {

    }

    public function postEdit()
    {

    }
}
