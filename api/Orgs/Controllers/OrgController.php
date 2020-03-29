<?php

namespace Api\Orgs\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\Orgs\Requests\CreateOrgRequest;
use Api\Orgs\Services\OrgService;
use Api\Orgs\Transformers\OrgTransformer;

class OrgController extends Controller
{
	private $srvc;

	public function __construct(OrgService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return OrgTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new OrgTransformer($this->srvc->getById($id));
	}
}
