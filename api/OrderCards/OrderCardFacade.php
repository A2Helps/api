<?php

namespace Api\OrderCards;

use Illuminate\Support\Facades\Facade;

class OrderCardFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'OrderCardService';
	}
}
