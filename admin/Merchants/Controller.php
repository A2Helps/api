<?php

namespace Admin\Merchants;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Admin\Merchants\CreateMerchantRequest;
use Admin\Merchants\Services\AdminMerchantService;
use Api\Merchants\Transformers\MerchantTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(AdminMerchantService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return MerchantTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new MerchantTransformer($this->srvc->getById($id));
	}

	public function create(CreateMerchantRequest $request)
	{
		$data = $request->all();

		return new MerchantTransformer($this->srvc->create($data), 201);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new MerchantTransformer($this->srvc->update($id, $data));
	}
}
