<?php

namespace Api\BatchItems;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\BatchItems\Requests\CreateBatchItemRequest;
use Api\BatchItems\Services\BatchItemService;
use Api\BatchItems\Transformers\BatchItemTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(BatchItemService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return BatchItemTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new BatchItemTransformer($this->srvc->getById($id));
	}

	public function create(CreateBatchItemRequest $request)
	{
		$data = $request->all();

		return $this->response(
			new BatchItemTransformer($this->srvc->create($data)),
			201
		);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new BatchItemTransformer($this->srvc->update($id, $data));
	}
}
