<?php

namespace Api\Orgs\Transformers;

use Api\OrgMembers\Transformers\OrgMemberTransformer;
use Api\Recipients\Transformers\RecipientTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrgTransformer extends JsonResource
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

		$data['org_members'] = OrgMemberTransformer::collection($this->whenLoaded('orgMembers'));
		$data['recipients'] = RecipientTransformer::collection($this->whenLoaded('recipients'));

		return $data;
	}
}
