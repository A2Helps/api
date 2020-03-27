<?php

namespace Infrastructure\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestFailedException extends HttpException
{
	public function __construct(string $msg = 'Request Failed.', \Throwable $previous = null, $code = 0)
	{
		parent::__construct(402, $msg, $previous, [], $code);
	}

	public static function throw (?string $msg = null, ?\Throwable $previous = null)
	{
		throw new static($msg, $previous);
	}
}
