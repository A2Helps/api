<?php

namespace Admin\Orgs;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Admin\Orgs\Requests\CreateOrgRequest;
use Admin\Orgs\Services\AdminOrgService;
use Api\Orgs\Transformers\OrgTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(AdminOrgService $srvc)
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

	public function create(CreateOrgRequest $request)
	{
		$data = $request->all();

		return new OrgTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new OrgTransformer($this->srvc->update($id, $data));
	}
}
