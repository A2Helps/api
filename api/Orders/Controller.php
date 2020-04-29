<?php

namespace Api\Orders;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Orders\Requests\CreateOrderRequest;
use Api\Orders\Services\OrderService;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(OrderService $srvc)
	{
		$this->srvc = $srvc;
	}
}
