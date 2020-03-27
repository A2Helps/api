<?php

namespace Infrastructure\Exceptions\Formatters;

use Throwable;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\ExceptionFormatter as BaseExceptionFormatter;

class ExceptionFormatter extends BaseExceptionFormatter
{
	public function format(JsonResponse $response, Throwable $e, array $reporterResponses)
	{
		parent::format($response, $e, $reporterResponses);

		if (! $this->debug && array_key_exists('sentry', $reporterResponses)) {
			$response->setData(array_merge(
				(array) $response->getData(),
				['sentry_id' => $reporterResponses['sentry']]
			));
		}

		return $response;
	}
}
