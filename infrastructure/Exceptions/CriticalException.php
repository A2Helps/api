<?php

namespace Infrastructure\Exceptions;

use Log;

class CriticalException extends \Exception
{
	public function __construct(string $msg = null)
	{
		$msg = $msg ?: 'Error Critical.';
		Log::critical($msg);

		parent::__construct($msg);
	}
}
