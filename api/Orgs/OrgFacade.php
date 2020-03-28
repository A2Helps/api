<?php

namespace Api\Orgs;

use Illuminate\Support\Facades\Facade;

class OrgFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'OrgService';
	}
}
