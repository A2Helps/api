<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Controllers;

use Illuminate\Http\Request;
use Infrastructure\Http\Controller;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Requests\CreateTEMPLATE_UC_CAMELRequest;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Services\TEMPLATE_UC_CAMELService;

class TEMPLATE_UC_CAMELController extends Controller
{
	private $srvc;

	public function __construct(TEMPLATE_UC_CAMELService $srvc)
	{
		$this->srvc = $srvc;
	}
}
