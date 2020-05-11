<?php

namespace Api\BatchItems\Requests;

use Infrastructure\Http\ApiRequest;

class CreateBatchItemRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'batch_item'                  => 'array|required',
			'batch_item.name'             => 'required|string',
			'batch_item.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'batch_item.name'             => 'The full name of the batch_item',
			'batch_item.user_id'          => 'The ID of the User who owns this batch_item',
		];
	}
}
