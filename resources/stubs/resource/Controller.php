<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Requests\CreateTEMPLATE_UC_CAMELRequest;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Services\TEMPLATE_UC_CAMELService;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Transformers\TEMPLATE_UC_CAMELTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(TEMPLATE_UC_CAMELService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return TEMPLATE_UC_CAMELTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new TEMPLATE_UC_CAMELTransformer($this->srvc->getById($id));
	}

	public function create(CreateTEMPLATE_UC_CAMELRequest $request)
	{
		$data = $request->all();

		return $this->response(
			new TEMPLATE_UC_CAMELTransformer($this->srvc->create($data)),
			201
		);
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new TEMPLATE_UC_CAMELTransformer($this->srvc->update($id, $data));
	}
}
