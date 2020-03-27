<?php

namespace Api\Givers\Transformers;

use Api\GiverUsers\Transformers\GiverUserTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class GiverTransformer extends JsonResource
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

		$data['giver_users'] = GiverUserTransformer::collection($this->whenLoaded('giverUsers'));

		return $data;
	}
}
