<?php

namespace Api\Orgs\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\Orgs\Requests\CreateOrgRequest;
use Api\Orgs\Services\OrgService;

class OrgController extends Controller
{
	private $srvc;

	public function __construct(OrgService $srvc)
	{
		$this->srvc = $srvc;
	}
}
