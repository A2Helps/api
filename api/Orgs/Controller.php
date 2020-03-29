<?php

namespace Api\Orgs;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Orgs\Requests\CreateOrgRequest;
use Api\Orgs\Services\OrgService;
use Api\Orgs\Transformers\OrgTransformer;

class Controller extends BaseController
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
