<?php

namespace Infrastructure\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ForbiddenException extends HttpException
{
	public function __construct(\Throwable $previous = null, $code = 0)
	{
		parent::__construct(403, $previous ? $previous->getMessage() : 'Forbidden.', $previous, [], $code);
	}

	public static function throw (?\Throwable $previous = null, ?int $code = 0)
	{
		throw new static($previous, $code);
	}
}
