<?php

namespace Api\Cards\Requests;

use Infrastructure\Http\ApiRequest;

class CreateCardRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'card'                  => 'array|required',
			'card.name'             => 'required|string',
			'card.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'card.name'             => 'The full name of the card',
			'card.user_id'          => 'The ID of the User who owns this card',
		];
	}
}
