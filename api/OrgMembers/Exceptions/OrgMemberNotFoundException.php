<?php

namespace Api\OrgMembers\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrgMemberNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The orgUser was not found.');
	}
}
