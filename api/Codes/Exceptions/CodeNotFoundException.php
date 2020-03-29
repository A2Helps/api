<?php

namespace Api\Codes\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CodeNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The code was not found.');
	}
}
