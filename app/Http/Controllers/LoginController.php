<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $login = array(
            'username' => $request->username,
            'password' => $request->password,
            'level' => 1
        );

        if(Auth::attempt($login))
        {
            return redirect()->route('admin.cate.list');
        }
        else
        {
            return redirect()->back();
        }
    }
}
