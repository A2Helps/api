<?php

namespace Api\GiverUsers\Requests;

use Infrastructure\Http\ApiRequest;

class CreateGiverUserRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'giver_user'                  => 'array|required',
			'giver_user.name'             => 'required|string',
			'giver_user.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'giver_user.name'             => 'The full name of the giver_user',
			'giver_user.user_id'          => 'The ID of the User who owns this giver_user',
		];
	}
}
