<?php

namespace Api\GiverUsers\Transformers;

use Api\Givers\Transformers\GiverTransformer;
use Api\Users\Transformers\UserTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Transformers\ModelTransformer;

class GiverUserTransformer extends JsonResource
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
		$data['giver_id'] = shorten_uuid($data['giver_id']);
		$data['user_id'] = shorten_uuid($data['user_id']);

		$data['giver'] = new GiverTransformer($this->whenLoaded('giver'));
		$data['user'] = new UserTransformer($this->whenLoaded('user'));

		return $data;
	}
}
