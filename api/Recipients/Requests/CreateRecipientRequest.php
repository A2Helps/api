<?php

namespace Api\Recipients\Requests;

use Infrastructure\Http\ApiRequest;

class CreateRecipientRequest extends ApiRequest
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
