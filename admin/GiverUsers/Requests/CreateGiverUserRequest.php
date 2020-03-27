<?php

namespace Admin\GiverUsers\Requests;

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
			'giver_user'          => 'array|required',
			'giver_user.user_id'  => 'required',
			'giver_user.giver_id' => 'required',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
