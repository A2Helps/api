<?php

namespace Infrastructure\Exceptions\Formatters;

use Throwable;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\HttpExceptionFormatter as OptimusOrig;

class HttpExceptionFormatter extends OptimusOrig
{
	public function format(JsonResponse $response, Throwable $e, array $reporterResponses)
	{
		return parent::format($response, $e, $reporterResponses);
	}
}
