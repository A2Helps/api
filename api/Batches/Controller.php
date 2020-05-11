<?php

namespace Api\Batches;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Batches\Requests\CreateBatchRequest;
use Api\Batches\Services\BatchService;
use Api\Batches\Transformers\BatchTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(BatchService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return BatchTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new BatchTransformer($this->srvc->getById($id));
	}

	public function create(CreateBatchRequest $request)
	{
		$data = $request->all();

		return $this->response(
			new BatchTransformer($this->srvc->create($data)),
			201
		);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new BatchTransformer($this->srvc->update($id, $data));
	}
}
