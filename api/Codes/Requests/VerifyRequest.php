<?php

namespace Api\Codes\Requests;

use Infrastructure\Http\ApiRequest;

class VerifyRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'code'  => 'required|string',
			'phone' => 'required|digits:10'
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
