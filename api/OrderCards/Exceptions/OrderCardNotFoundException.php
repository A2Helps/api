<?php

namespace Api\OrderCards\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderCardNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The orderCard was not found.');
	}
}
