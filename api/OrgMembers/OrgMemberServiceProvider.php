<?php

namespace Api\OrgMembers;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\OrgMembers\Services\OrgMemberService;

class OrgMemberServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = OrgMemberService::class;
}
