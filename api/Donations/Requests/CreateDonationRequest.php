<?php

namespace Api\Donations\Requests;

use Infrastructure\Http\ApiRequest;

class CreateDonationRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'amount' => 'required|int',
		];
	}

	public function attributes(): array
	{
		return [
			'amount' => 'The donation amount in USD cents',
		];
	}
}
