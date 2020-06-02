<?php

namespace Api\Merchants\Requests;

use Infrastructure\Http\ApiRequest;

class CreateMerchantRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'name' => 'required|string',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
