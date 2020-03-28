<?php

namespace Admin\Orgs;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Admin\Orgs\Services\AdminOrgService;

class OrgServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminOrgService::class;
}
