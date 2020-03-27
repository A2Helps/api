<?php

namespace Api\GiverUsers\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GiverUserNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The giverUser was not found.');
	}
}
