<?php

namespace Admin\Codes;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Admin\Codes\Requests\CreateCodeRequest;
use Admin\Codes\Services\AdminCodeService;
use Api\Codes\Transformers\CodeTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(AdminCodeService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return CodeTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new CodeTransformer($this->srvc->getById($id));
	}

	public function create(CreateCodeRequest $request)
	{
		$data = $request->all();

		return new CodeTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new CodeTransformer($this->srvc->update($id, $data));
	}
}
