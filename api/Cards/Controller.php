<?php

namespace Api\Cards;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Cards\Requests\CreateCardRequest;
use Api\Cards\Services\CardService;

class Controller extends BaseController
{
	private $srvc;

	public function __construct(CardService $srvc)
	{
		$this->srvc = $srvc;
	}
}
