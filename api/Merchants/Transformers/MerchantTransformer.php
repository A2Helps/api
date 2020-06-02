<?php

namespace Api\Merchants\Transformers;

use Log;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MerchantTransformer extends JsonResource
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

		if (empty($data['amounts'])) {
			$data['amounts'] = [];
		}

		$data['amounts'] = collect($data['amounts'])->map(function($v) { return (int) $v; });

		return $data;
	}
}
