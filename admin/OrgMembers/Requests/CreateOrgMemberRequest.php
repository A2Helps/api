<?php

namespace Admin\OrgMembers\Requests;

use Infrastructure\Http\ApiRequest;

class CreateOrgMemberRequest extends ApiRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'user_id'  => 'required',
			'org_id' => 'required',
		];
	}

	public function attributes(): array
	{
		return [

		];
	}
}
