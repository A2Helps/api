<?php

namespace Admin\GiverUsers\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Admin\GiverUsers\Requests\CreateGiverUserRequest;
use Admin\GiverUsers\Services\AdminGiverUserService;
use Api\GiverUsers\Transformers\GiverUserTransformer;

class GiverUserController extends Controller
{
	private $srvc;

	public function __construct(AdminGiverUserService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return GiverUserTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new GiverUserTransformer($this->srvc->getById($id));
	}

	public function create(CreateGiverUserRequest $request)
	{
		$data = $request->all();

		return new GiverUserTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new GiverUserTransformer($this->srvc->update($id, $data));
	}
}
