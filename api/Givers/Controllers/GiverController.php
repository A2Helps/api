<?php

namespace Api\Givers\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\Givers\Requests\CreateGiverRequest;
use Api\Givers\Services\GiverService;

class GiverController extends Controller
{
	private $srvc;

	public function __construct(GiverService $srvc)
	{
		$this->srvc = $srvc;
	}
}
