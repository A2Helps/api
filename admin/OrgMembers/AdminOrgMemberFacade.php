<?php

namespace Admin\OrgMembers;

use Illuminate\Support\Facades\Facade;

class AdminOrgMemberFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'AdminOrgMemberService';
	}
}
