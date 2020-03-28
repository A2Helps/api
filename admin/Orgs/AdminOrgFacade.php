<?php

namespace Admin\Orgs;

use Illuminate\Support\Facades\Facade;

class AdminOrgFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminOrgService';
	}
}
