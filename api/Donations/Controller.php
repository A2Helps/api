<?php

namespace Api\Donations;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Api\Donations\Requests\CreateDonationRequest;
use Api\Donations\Services\DonationService;
use Api\Donations\Transformers\DonationTransformer;
use Illuminate\Support\Arr;

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

	public function getAll()
	{
		if (auth()->check() && auth()->user()->operator) {
			return DonationTransformer::collection($this->srvc->getAll());
		}

		return $this->srvc->getAll();
	}

	public function update($id, Request $request)
	{
		$data = $request->all();

		Arr::forget($data, ['completed']);

		$this->srvc->update($id, $data);
		return;
	}
}
