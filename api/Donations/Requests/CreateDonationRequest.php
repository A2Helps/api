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
			'wired_from'  => 'nullable|string|required_if:wired,true',
			'public'      => 'bool',
			'public_name' => 'nullable|string|required_if:public,true',
			'email'       => 'nullable|email|required_if:wired,true',
		];
	}

	public function attributes(): array
	{
		return [
			'amount' => 'The donation amount in USD cents.',
			'email' => 'Email address of the contributor. Required if wired.',
			'public_name' => 'Name to list publically. Required if public.',
			'wired_from' => 'Name of the person who created wire, used to track receipt of wire. Required if wired.',
		];
	}
}
