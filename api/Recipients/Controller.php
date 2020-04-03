<?php

namespace Api\Recipients;

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
}
