<?php

namespace Admin\GiverUsers;

use Illuminate\Support\Facades\Facade;

class AdminGiverUserFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminGiverUserService';
	}
}
