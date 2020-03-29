<?php

namespace Api\Recipients\Requests;

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
			'recipients'   => 'required|array',
			'recipients.*' => 'string'
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
