<?php

namespace Api\Cards\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CardNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The card was not found.');
	}
}
