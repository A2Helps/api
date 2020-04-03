<?php

namespace Admin\Users;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Admin\Users\Requests\CreateUserRequest;
use Admin\Users\Services\AdminUserService;
use Api\Users\Transformers\UserTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(AdminUserService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return UserTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new UserTransformer($this->srvc->getById($id));
	}

	public function create(CreateUserRequest $request)
	{
		$data = $request->get('user', []);

		return new UserTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new UserTransformer($this->srvc->update($id, $data));
	}

	public function createToken($id, Request $request)
	{
		$data = $request->all();

		return $this->srvc->createAuthToken($id);
	}

	public function deleteByPhone($phone, Request $request)
	{
		return $this->srvc->deleteByPhone($phone);
	}
}
