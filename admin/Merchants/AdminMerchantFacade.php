<?php

namespace Admin\Merchants;

use Illuminate\Support\Facades\Facade;

class AdminMerchantFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminMerchantService';
	}
}
