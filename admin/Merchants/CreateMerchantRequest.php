<?php

namespace Admin\Merchants;

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
			'name'    => 'required|string',
			'img_url' => 'nullable|string',
			'active'  => 'bool',
			'amounts' => 'string'
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
