<?php

namespace Api\Donations;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Donations\Requests\CreateDonationRequest;
use Api\Donations\Services\DonationService;
use Api\Donations\Transformers\DonationTransformer;

class Controller extends BaseController
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

	public function update($id, Request $request)
	{
		$data = $request->all();

		return new DonationTransformer($this->srvc->update($id, $data));
	}
}
