<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'txtUser' => 'required|unique:users,username',
			'txtPass' => 'required',
			'txtRePass' => 'required|same:txtPass',
			'txtEmail' => 'required|email|unique:users,email'
		];
	}

	public function messages()
	{
		return [
			'txtUser.required' => 'Please enter username',
			'txtUser.unique' => 'Username has existed',
			'txtPass.required' => 'Please enter password',
			'txtRePass.required' => 'Please enter re-password',
			'txtRePass.same' => 'Re-password doesn\'t match password',
			'txtEmail.required' => 'Please enter email',
			'txtEmail.email' => 'Email error syntax',
			'txtEmail.unique' => 'Email has existed'
		];
	}
}
