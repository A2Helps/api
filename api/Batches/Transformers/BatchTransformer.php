<?php

namespace Api\Batches\Transformers;

use Api\BatchItems\Transformers\BatchItemTransformer;
use Api\Merchants\Transformers\MerchantTransformer;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchTransformer extends JsonResource
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
			$this->resource->toArray(),
			['assigned_to']
		);

		$data['batch_items'] = BatchItemTransformer::collection($this->whenLoaded('batchItems'));
		$data['merchant'] = new MerchantTransformer($this->whenLoaded('merchant'));

		return $data;
	}
}
