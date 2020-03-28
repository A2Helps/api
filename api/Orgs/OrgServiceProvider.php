<?php

namespace Api\Orgs;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Orgs\Services\OrgService;

class OrgServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = OrgService::class;
}
