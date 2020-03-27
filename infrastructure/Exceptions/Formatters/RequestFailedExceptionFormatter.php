<?php

namespace Infrastructure\Exceptions\Formatters;

use Throwable;
use Illuminate\Http\JsonResponse;

class RequestFailedExceptionFormatter extends HttpExceptionFormatter
{
	public function format(JsonResponse $response, Throwable $e, array $reporterResponses)
	{
		// request failure errors will return JSON string
		$decoded = json_decode($e->getMessage(), true);
		// Message was not valid JSON
		if (json_last_error() !== JSON_ERROR_NONE) {
			$decoded = [
				'error' => [
					'code' => 0,
					'reason' => $e->getMessage()
				]
			];
		}

		$response->setStatusCode($e->getStatusCode());
		$response->setData($decoded);
	}
}
