<?php

namespace Api\OrgMembers\Requests;

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
			'org_member'                  => 'array|required',
			'org_member.name'             => 'required|string',
			'org_member.user_id'          => 'required|uuid',
		];
	}

	public function attributes(): array
	{
		return [
			'org_member.name'             => 'The full name of the org_member',
			'org_member.user_id'          => 'The ID of the User who owns this org_member',
		];
	}
}
