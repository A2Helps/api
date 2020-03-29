<?php

namespace Api\Codes;

use Illuminate\Support\Facades\Facade;

class CodeFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'CodeService';
	}
}
