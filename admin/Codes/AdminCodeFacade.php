<?php

namespace Admin\Codes;

use Illuminate\Support\Facades\Facade;

class AdminCodeFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminCodeService';
	}
}
