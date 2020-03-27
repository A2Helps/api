<?php

namespace Infrastructure\Exceptions;

use Log;

class EmergencyException extends \Exception
{
	public function __construct(string $msg = null)
	{
		$msg = $msg ?: 'Error Emergency.';
		Log::emergency($msg);

		parent::__construct($msg);
	}
}
