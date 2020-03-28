<?php

namespace Api\OrgMembers\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\OrgMembers\Requests\CreateOrgMemberRequest;
use Api\OrgMembers\Services\OrgMemberService;

class OrgMemberController extends Controller
{
	private $srvc;

	public function __construct(OrgMemberService $srvc)
	{
		$this->srvc = $srvc;
	}
}
