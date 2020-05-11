<?php

namespace Api\Users;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Users\Requests\CreateUserRequest;
use Api\Users\Services\UserService;
use Api\Users\Transformers\UserTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(UserService $srvc)
	{
		$this->srvc = $srvc;
	}

	// public function getAll()
	// {
	// 	$resourceOptions = $this->parseResourceOptions();

	// 	$data = $this->srvc->getAll($resourceOptions);
	// 	$parsedData = $this->parseData($data, $resourceOptions, 'users');

	// 	return $this->response($parsedData);
	// }

	public function getById($id)
	{
		return new UserTransformer($this->srvc->getById($id));
	}

	// public function create(CreateUserRequest $request)
	// {
	// 	$data = $request->get('user', []);

	// 	return $this->response($this->srvc->create($data), 201);
	// }

	// public function update($userId, Request $request)
	// {
	// 	$data = $request->get('user', []);

	// 	return $this->response($this->srvc->update($userId, $data));
	// }

	// public function delete($userId)
	// {
	// 	return $this->response($this->srvc->delete($userId));
	// }

	public function getMe()
	{
		return $this->getById(auth()->user()->id);
	}
}
