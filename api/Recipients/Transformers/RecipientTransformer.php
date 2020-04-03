<?php

namespace Api\Recipients\Transformers;

use Api\RecipientMembers\Transformers\RecipientMemberTransformer;
use Api\Codes\Transformers\CodeTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
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

		$data['recipient_members'] = RecipientMemberTransformer::collection($this->whenLoaded('recipientMembers'));
		$data['codes'] = CodeTransformer::collection($this->whenLoaded('codes'));

		return $data;
	}
}
