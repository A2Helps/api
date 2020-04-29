<?php

namespace Api\Cards;

use Illuminate\Support\Facades\Facade;

class CardFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'CardService';
	}
}
