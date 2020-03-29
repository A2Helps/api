<?php

namespace Api\Codes;

use Api\Codes\Requests\BulkUpdateRequest;
use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Codes\Requests\CreateCodeRequest;
use Api\Codes\Services\CodeService;
use Api\Codes\Transformers\CodeTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(CodeService $srvc)
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

	public function bulkUpdate(BulkUpdateRequest $request)
	{
		$data = $request->get('data', []);
		$codes = $request->get('codes', []);

		return CodeTransformer::collection($this->srvc->bulkUpdate($codes, $data));
	}
}
