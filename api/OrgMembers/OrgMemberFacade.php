<?php

namespace Api\OrgMembers;

use Illuminate\Support\Facades\Facade;

class OrgMemberFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'OrgMemberService';
	}
}
