<?php

namespace Api\Givers\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GiverNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The giver was not found.');
	}
}
