<?php

namespace Admin\Users;

use Illuminate\Support\Facades\Facade;

class AdminUserFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminUserService';
	}
}
