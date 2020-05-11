<?php

namespace Api\Batches;

use Illuminate\Support\Facades\Facade;

class BatchFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'BatchService';
	}
}
