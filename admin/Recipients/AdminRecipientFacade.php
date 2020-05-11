<?php

namespace Admin\Recipients;

use Illuminate\Support\Facades\Facade;

class AdminRecipientFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminRecipientService';
	}
}
