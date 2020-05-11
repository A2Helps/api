<?php

namespace Api\BatchItems\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BatchItemNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The batchItem was not found.');
	}
}
