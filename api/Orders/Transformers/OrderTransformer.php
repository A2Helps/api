<?php

namespace Api\Orders\Transformers;

use Api\OrderCards\Transformers\OrderCardTransformer;
use Api\Orgs\Transformers\OrgTransformer;
use Api\Users\Transformers\UserTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Transformers\ModelTransformer;

class OrderTransformer extends JsonResource
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
		$data['code_id'] = shorten_uuid($data['code_id']);
		$data['user_id'] = shorten_uuid($data['user_id']);

		$data['order_cards'] = OrderCardTransformer::collection($this->whenLoaded('orderCards'));

		return $data;
	}
}
