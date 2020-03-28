<?php

namespace Api\Orgs\Requests;

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
			'org'                  => 'array|required',
			'org.name'             => 'required|string',
			'org.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'org.name'             => 'The full name of the org',
			'org.user_id'          => 'The ID of the User who owns this org',
		];
	}
}
