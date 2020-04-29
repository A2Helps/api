<?php

namespace Api\Orders\Transformers;

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
		$data['org_id'] = shorten_uuid($data['org_id']);
		$data['user_id'] = shorten_uuid($data['user_id']);

		$data['org'] = new OrgTransformer($this->whenLoaded('org'));
		$data['user'] = new UserTransformer($this->whenLoaded('user'));

		return $data;
	}
}
