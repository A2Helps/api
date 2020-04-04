<?php

namespace Api\Merchants;

use Illuminate\Support\Facades\Facade;

class MerchantFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'MerchantService';
	}
}
