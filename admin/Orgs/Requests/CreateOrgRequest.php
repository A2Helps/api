<?php

namespace Admin\Orgs\Requests;

use Infrastructure\Http\ApiRequest;

class CreateOrgRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'name'      => 'required|string',
			'allotment' => 'required|int',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
