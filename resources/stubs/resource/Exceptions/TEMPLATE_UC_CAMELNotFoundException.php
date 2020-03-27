<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TEMPLATE_UC_CAMELNotFoundException extends NotFoundHttpException
{
	public function __construct()
	{
		parent::__construct('The TEMPLATE_LC_CAMEL was not found.');
	}
}
