<?php

namespace Api\Orders\Requests;

use Infrastructure\Http\ApiRequest;

class CreateOrderRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'order'                  => 'array|required',
			'order.name'             => 'required|string',
			'order.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'order.name'             => 'The full name of the order',
			'order.user_id'          => 'The ID of the User who owns this order',
		];
	}
}
