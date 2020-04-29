<?php

namespace Api\OrderCards;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\OrderCards\Requests\CreateOrderCardRequest;
use Api\OrderCards\Services\OrderCardService;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(OrderCardService $srvc)
	{
		$this->srvc = $srvc;
	}
}
