<?php

namespace Api\Orders\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The order was not found.');
	}
}
