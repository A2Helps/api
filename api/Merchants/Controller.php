<?php

namespace Api\Merchants;

use Infrastructure\Http\Controller as BaseController;
use Api\Merchants\Services\MerchantService;
use Api\Merchants\Transformers\MerchantTransformer;

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
}
