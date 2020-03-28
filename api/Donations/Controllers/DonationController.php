<?php

namespace Api\Donations\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use Api\Donations\Requests\CreateDonationRequest;
use Api\Donations\Services\DonationService;
use Api\Donations\Transformers\DonationTransformer;

class DonationController extends Controller
{
	private $srvc;

	public function __construct(DonationService $srvc)
	{
		$this->srvc = $srvc;
	}

	public function create(CreateDonationRequest $request)
	{
		$data = $request->all();

		return new DonationTransformer($this->srvc->create($data), 201);
	}
}
