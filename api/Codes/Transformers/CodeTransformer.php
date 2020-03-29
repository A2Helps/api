<?php

namespace Api\Codes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CodeTransformer extends JsonResource
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

		if (! empty($data['org_id'])) {
			$data['org_id'] = shorten_uuid($data['org_id']);
		}

		if (! empty($data['org_member_id'])) {
			$data['org_member_id'] = shorten_uuid($data['org_member_id']);
		}

		return $data;
	}
}
