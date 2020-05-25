<?php

namespace Api\Recipients\Transformers;

use Api\RecipientMembers\Transformers\RecipientMemberTransformer;
use Api\Codes\Transformers\CodeTransformer;
use Api\Orgs\Transformers\OrgTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RecipientTransformer extends JsonResource
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

		$data['org'] = new OrgTransformer($this->whenLoaded('org'));

		return Arr::only($data, ['id', 'name_first', 'name_last']);
	}
}
