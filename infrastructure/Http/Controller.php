<?php

namespace Infrastructure\Http;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Infrastructure\Transformers\ModelTransformer;
use Illuminate\Routing\Controller as LaravelController;
use JsonSerializable;

abstract class Controller extends LaravelController
{
	protected function transform($data, bool $shallow = false)
	{
		return ModelTransformer::transform($data, $shallow);
	}

	protected function transformedResponse($data, $shallow = false)
	{
		return $this->response(
			$this->transform($data, $shallow)
		);
	}

	protected function transformResponse($data, $statusCode = 200, array $headers = [])
	{
		return $this->response($data, $statusCode, $headers);
	}

	/**
	* Create a json response
	* @param  mixed  $data
	* @param  integer $statusCode
	* @param  array  $headers
	* @return Illuminate\Http\JsonResponse
	*/
	protected function response($data, $statusCode = 200, array $headers = [])
	{
		if ($data instanceof Arrayable && !$data instanceof JsonSerializable) {
			$data = $data->toArray();
		}

		return new JsonResponse($data, $statusCode, $headers);
	}
}
