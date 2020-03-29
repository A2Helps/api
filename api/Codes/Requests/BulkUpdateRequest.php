<?php

namespace Api\Codes\Requests;

use Infrastructure\Http\ApiRequest;

class BulkUpdateRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'data'         => 'required|array',
			'codes'   => 'required|array',
			'codes.*' => 'string'
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
