<?php

namespace Api\Givers\Requests;

use Infrastructure\Http\ApiRequest;

class CreateGiverRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'giver'                  => 'array|required',
			'giver.name'             => 'required|string',
			'giver.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'giver.name'             => 'The full name of the giver',
			'giver.user_id'          => 'The ID of the User who owns this giver',
		];
	}
}
