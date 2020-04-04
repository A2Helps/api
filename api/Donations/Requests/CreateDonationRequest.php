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
			'amount'      => 'required|int',
			'wired'       => 'bool',
			'wired_from'  => 'nullable|string',
			'public'      => 'bool',
			'public_from' => 'nullable|string',
			'email'       => 'nullable|email|required_if:wired,true',
		];
	}

	public function attributes(): array
	{
		return [
			'amount' => 'The donation amount in USD cents',
		];
	}
}
