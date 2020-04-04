<?php

namespace Api\Merchants\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MerchantNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The merchant was not found.');
	}
}
