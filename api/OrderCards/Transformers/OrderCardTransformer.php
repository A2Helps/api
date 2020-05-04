<?php

namespace Api\OrderCards\Transformers;

use Api\Merchants\Transformers\MerchantTransformer;
use Api\Orgs\Transformers\OrgTransformer;
use Api\Users\Transformers\UserTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Transformers\ModelTransformer;

class OrderCardTransformer extends JsonResource
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
		$data['order_id'] = shorten_uuid($data['order_id']);
		$data['merchant_id'] = shorten_uuid($data['merchant_id']);
		$data['card_id'] = shorten_uuid($data['card_id']);

		$data['merchant'] = new MerchantTransformer($this->whenLoaded('merchant'));

		return $data;
	}
}
