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
			'user_id'  => 'required',
			'giver_id' => 'required',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
