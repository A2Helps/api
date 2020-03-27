<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Services\TEMPLATE_UC_CAMELService;

class TEMPLATE_UC_CAMELServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = TEMPLATE_UC_CAMELService::class;
}
