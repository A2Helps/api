<?php

namespace Api\Codes\Requests;

use Infrastructure\Http\ApiRequest;

class RedeemRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'merchants'          => 'required|array',
			'merchants.*'        => 'array',
			'merchants.*.id'     => 'required|string',
			'merchants.*.amount' => 'required|integer',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
