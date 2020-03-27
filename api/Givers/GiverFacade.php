<?php

namespace Api\Givers;

use Illuminate\Support\Facades\Facade;

class GiverFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'GiverService';
	}
}
