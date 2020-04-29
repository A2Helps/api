<?php

namespace Api\OrderCards\Requests;

use Infrastructure\Http\ApiRequest;

class CreateOrderCardRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'order_card'                  => 'array|required',
			'order_card.name'             => 'required|string',
			'order_card.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'order_card.name'             => 'The full name of the order_card',
			'order_card.user_id'          => 'The ID of the User who owns this order_card',
		];
	}
}
