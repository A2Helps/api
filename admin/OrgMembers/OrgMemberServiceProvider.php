<?php

namespace Admin\OrgMembers;

use Admin\OrgMembers\Services\AdminOrgMemberService;
use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;

class OrgMemberServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminOrgMemberService::class;
}
