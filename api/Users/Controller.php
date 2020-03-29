<?php

namespace Api\Users;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Users\Requests\CreateUserRequest;
use Api\Users\Services\UserService;

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

	// public function getById($userId)
	// {
	// 	$resourceOptions = $this->parseResourceOptions();

	// 	$data = $this->srvc->getById($userId, $resourceOptions);
	// 	$parsedData = $this->parseData($data, $resourceOptions, 'user');

	// 	return $this->response($parsedData);
	// }

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
}
