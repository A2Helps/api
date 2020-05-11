<?php

namespace Admin\Users\Requests;

use Infrastructure\Http\ApiRequest;

class CreateUserRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'user'            => 'array|required',
			'user.email'      => 'required|email',
			'user.password'   => 'required|string|min:6',
			'user.name_first' => 'required|string',
			'user.name_last'  => 'required|string',
			'user.operator'   => 'boolean',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
