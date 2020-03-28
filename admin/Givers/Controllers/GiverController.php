<?php

namespace Admin\Givers\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Admin\Givers\Requests\CreateGiverRequest;
use Admin\Givers\Services\AdminGiverService;
use Api\Givers\Transformers\GiverTransformer;

class GiverController extends Controller
{
	private $srvc;

	public function __construct(AdminGiverService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return GiverTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new GiverTransformer($this->srvc->getById($id));
	}

	public function create(CreateGiverRequest $request)
	{
		$data = $request->all();

		return new GiverTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new GiverTransformer($this->srvc->update($id, $data));
	}
}
