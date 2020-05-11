<?php

namespace Api\BatchItems;

use Illuminate\Support\Facades\Facade;

class BatchItemFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'BatchItemService';
	}
}
