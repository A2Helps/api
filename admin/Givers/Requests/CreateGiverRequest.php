<?php

namespace Admin\Givers\Requests;

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
			'giver'           => 'array|required',
			'giver.name'      => 'required|string',
			'giver.allotment' => 'required|int',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
