<?php

namespace Api\Donations;

use Illuminate\Support\Facades\Facade;

class DonationFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'DonationService';
	}
}
