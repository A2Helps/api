<?php

namespace Api\Recipients\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipientNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The recipient was not found.');
	}
}
