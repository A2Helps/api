<?php

namespace Admin\Recipients;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Admin\Recipients\CreateRecipientRequest;
use Admin\Recipients\Services\AdminRecipientService;
use Api\Recipients\Transformers\RecipientTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(AdminRecipientService $srvc)
	{
		$this->srvc = $srvc;
	}

	// public function getAll()
	// {
	// 	return RecipientTransformer::collection($this->srvc->getAll());
	// }

	// public function getById($id)
	// {
	// 	return new RecipientTransformer($this->srvc->getById($id));
	// }

	// public function create(CreateRecipientRequest $request)
	// {
	// 	$data = $request->all();

	// 	return new RecipientTransformer($this->srvc->create($data), 201);
	// }

	// public function update($id, Request $request)
	// {
	// 	$data = $request->all();

	// 	return new RecipientTransformer($this->srvc->update($id, $data));
	// }

	public function deleteByPhone($phone, Request $request)
	{
		return $this->srvc->deleteByPhone($phone);
	}

	public function deleteByemail($email, Request $request)
	{
		return $this->srvc->deleteByEmail($email);
	}
}
