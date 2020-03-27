<?php

namespace Infrastructure\Exceptions;

use Log;

class AlertException extends \Exception
{
	public function __construct(string $msg = null)
	{
		$msg = $msg ?: 'Error Alert.';
		Log::alert($msg);

		parent::__construct($msg);
	}
}
