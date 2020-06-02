<?php

namespace Api\Merchants;

use Api\Merchants\Requests\CreateMerchantRequest;
use Infrastructure\Http\Controller as BaseController;
use Api\Merchants\Services\MerchantService;
use Api\Merchants\Transformers\MerchantTransformer;
use Illuminate\Http\Request;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(MerchantService $srvc)
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

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new MerchantTransformer($this->srvc->update($id, $data));
	}

	public function create(CreateMerchantRequest $request)
	{
		$data = $request->all();

		return new MerchantTransformer($this->srvc->create($data));
	}
}
