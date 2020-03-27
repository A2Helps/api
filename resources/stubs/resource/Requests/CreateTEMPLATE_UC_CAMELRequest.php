<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Requests;

use Infrastructure\Http\ApiRequest;

class CreateTEMPLATE_UC_CAMELRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'TEMPLATE_LC_SNAKE'                  => 'array|required',
			'TEMPLATE_LC_SNAKE.name'             => 'required|string',
			'TEMPLATE_LC_SNAKE.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'TEMPLATE_LC_SNAKE.name'             => 'The full name of the TEMPLATE_LC_SNAKE',
			'TEMPLATE_LC_SNAKE.user_id'          => 'The ID of the User who owns this TEMPLATE_LC_SNAKE',
		];
	}
}
