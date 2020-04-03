<?php

namespace Api\Recipients\Requests;

use Infrastructure\Http\ApiRequest;

class CreateRecipientRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'recipient'                  => 'array|required',
			'recipient.name'             => 'required|string',
			'recipient.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'recipient.name'             => 'The full name of the recipient',
			'recipient.user_id'          => 'The ID of the User who owns this recipient',
		];
	}
}
