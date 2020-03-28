<?php

namespace Admin\OrgMembers\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Admin\OrgMembers\Requests\CreateOrgMemberRequest;
use Admin\OrgMembers\Services\AdminOrgMemberService;
use Api\OrgMembers\Transformers\OrgMemberTransformer;

class OrgMemberController extends Controller
{
	private $srvc;

	public function __construct(AdminOrgMemberService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return OrgMemberTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new OrgMemberTransformer($this->srvc->getById($id));
	}

	public function create(CreateOrgMemberRequest $request)
	{
		$data = $request->all();

		return new OrgMemberTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new OrgMemberTransformer($this->srvc->update($id, $data));
	}
}
