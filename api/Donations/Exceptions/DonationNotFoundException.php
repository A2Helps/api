<?php

namespace Api\Donations\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DonationNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The donation was not found.');
	}
}
