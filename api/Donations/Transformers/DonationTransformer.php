<?php

namespace Api\Donations\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DonationTransformer extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		$data = $this->resource->toArray();

		$data['id'] = shorten_uuid($data['id']);

		return $data;
	}
}
