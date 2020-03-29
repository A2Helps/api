<?php

namespace Api\Recipients;

use Api\Recipients\Requests\BulkUpdateRequest;
use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Recipients\Requests\CreateRecipientRequest;
use Api\Recipients\Services\RecipientService;
use Api\Recipients\Transformers\RecipientTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(RecipientService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return RecipientTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new RecipientTransformer($this->srvc->getById($id));
	}

	public function create(CreateRecipientRequest $request)
	{
		$data = $request->all();

		return new RecipientTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new RecipientTransformer($this->srvc->update($id, $data));
	}

	public function bulkUpdate(BulkUpdateRequest $request)
	{
		$data = $request->get('data', []);
		$recipients = $request->get('recipients', []);

		return RecipientTransformer::collection($this->srvc->bulkUpdate($recipients, $data));
	}
}
