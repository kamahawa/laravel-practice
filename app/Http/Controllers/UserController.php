<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
//use Illuminate\Foundation\Auth\User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
		return redirect()->route('admin.user.list')->with(['flash_level' => 'success', 'flash_message' => 'Success!! Complete add user']);
	}

	public function getDelete($id)
	{
		$user_current_login = User::find(Auth::user()->id);
		$user = User::find($id);
		if ($user['level'] == 1) {
			return redirect()->route('admin.user.list')->with(['flash_level' => 'danger', 'flash_message' => 'Failed!! You can\'st accept delete this user.']);
		} else if ($user['level'] == 2 && $user_current_login['level'] == 2) {
			return redirect()->route('admin.user.list')->with(['flash_level' => 'danger', 'flash_message' => 'Failed!! You can\'t accept delete this user.']);
		} else {
			$user->delete($id);
			return redirect()->route('admin.user.list')->with(['flash_level' => 'success', 'flash_message' => 'Success!! Complete delete user']);
		}

	}

	public function getEdit($id)
	{
		$data = User::find($id);
		if (Auth::user()->level != 1) {
			if (Auth::user()->level != 2 || (Auth::user()->level == 2 && $data['level'] == 2)) {
				return redirect()->route('admin.user.list')->with(['flash_level' => 'danger', 'flash_message' => 'Failed!! You can\'t accept edit this user.']);
			}
		}
		return view('admin.user.edit', compact('data', 'id'));
	}

	public function postEdit($id, Request $request)
	{
		$user = User::find($id);
		if ($request->txtPass) {
			$this->validate($request, [
					'txtRePass' => 'same:txtPass'
				],
				[
					'txtRePass.same' => 'Re-password doesn\'t match password'
				]);
			$pass = $request->txtPass;
			$user->password = Hash::make($pass);
		}
		$user->email = $request->txtEmail;
		$user->level = $request->rdoLevel;
		$user->remember_token = $request->_token;
		$user->save();
		return redirect()->route('admin.user.list')->with(['flash_level' => 'success', 'flash_message' => 'Success!! Complete edit user']);
	}
}
