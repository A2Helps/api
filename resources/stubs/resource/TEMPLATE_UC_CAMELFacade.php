<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL;

use Illuminate\Support\Facades\Facade;

class TEMPLATE_UC_CAMELFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'TEMPLATE_UC_CAMELService';
	}
}
