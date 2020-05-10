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
			'name_first' => 'required|string',
			'name_last'  => 'required|string',
			'phone'      => 'required|digits:10',
			'email'      => 'required|email',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
