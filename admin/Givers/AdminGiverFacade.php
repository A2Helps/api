<?php

namespace Admin\Givers;

use Illuminate\Support\Facades\Facade;

class AdminGiverFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminGiverService';
	}
}
