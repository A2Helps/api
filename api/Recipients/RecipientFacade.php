<?php

namespace Api\Recipients;

use Illuminate\Support\Facades\Facade;

class RecipientFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'RecipientService';
	}
}
