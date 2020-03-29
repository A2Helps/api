<?php

namespace Api\OrgMembers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\OrgMembers\Requests\CreateOrgMemberRequest;
use Api\OrgMembers\Services\OrgMemberService;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(OrgMemberService $srvc)
	{
		$this->srvc = $srvc;
	}
}
