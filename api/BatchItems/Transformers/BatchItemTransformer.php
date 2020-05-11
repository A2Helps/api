<?php

namespace Api\BatchItems\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BatchItemTransformer extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		$data = shorten_array_uuids(
			$this->resource->toArray()
		);

		return $data;
	}
}
