<?php

namespace Api\GiverUsers;

use Illuminate\Support\Facades\Facade;

class GiverUserFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'GiverUserService';
	}
}
