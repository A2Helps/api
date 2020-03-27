<?php

namespace Api\GiverUsers\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\GiverUsers\Requests\CreateGiverUserRequest;
use Api\GiverUsers\Services\GiverUserService;

class GiverUserController extends Controller
{
	private $srvc;

	public function __construct(GiverUserService $srvc)
	{
		$this->srvc = $srvc;
	}
}
