<?php

namespace Api\Batches\Requests;

use Infrastructure\Http\ApiRequest;

class CreateBatchRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'batch'                  => 'array|required',
			'batch.name'             => 'required|string',
			'batch.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'batch.name'             => 'The full name of the batch',
			'batch.user_id'          => 'The ID of the User who owns this batch',
		];
	}
}
