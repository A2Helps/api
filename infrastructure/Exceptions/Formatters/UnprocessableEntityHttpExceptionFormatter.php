<?php

namespace Infrastructure\Exceptions\Formatters;

use Throwable;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\UnprocessableEntityHttpExceptionFormatter as OptimusOrig;

class UnprocessableEntityHttpExceptionFormatter extends OptimusOrig
{
    public function format(JsonResponse $response, Throwable $e, array $reporterResponses)
    {
        parent::format($response, $e, $reporterResponses);

        $response->setStatusCode($e->getStatusCode());
    }
}
