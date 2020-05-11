<?php

namespace Api\Batches\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BatchNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The batch was not found.');
	}
}
