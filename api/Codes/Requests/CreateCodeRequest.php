<?php

namespace Api\Codes\Requests;

use Infrastructure\Http\ApiRequest;

class CreateCodeRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'name'  => 'string',
			'email' => 'email',
			'phone' => 'digits:10'
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
