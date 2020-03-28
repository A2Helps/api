<?php

namespace Api\Orgs\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrgNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The org was not found.');
	}
}
