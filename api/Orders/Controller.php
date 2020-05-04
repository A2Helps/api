<?php

namespace Api\Orders;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Orders\Requests\CreateOrderRequest;
use Api\Orders\Services\OrderService;
use Api\Orders\Transformers\OrderTransformer;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(OrderService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function getAll()
	{
		return OrderTransformer::collection($this->srvc->getAll());
	}

	public function getById($id)
	{
		return new OrderTransformer($this->srvc->getById($id));
	}
}
