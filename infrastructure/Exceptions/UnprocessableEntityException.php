<?php

namespace Infrastructure\Exceptions;

use Log;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UnprocessableEntityException extends UnprocessableEntityHttpException
{
	public function __construct(string $where, $message = 'Unprocessable.', \Throwable $previous = null, $code = 0)
	{
		Log::notice('Unprocessable request', [
			'where' => $where
		]);

		// responseCode is 422
		parent::__construct($message, $previous, $code);
	}

	public static function throw (string $where)
	{
		throw new static($where);
	}
}
