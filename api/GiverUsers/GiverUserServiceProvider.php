<?php

namespace Api\GiverUsers;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\GiverUsers\Services\GiverUserService;

class GiverUserServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = GiverUserService::class;
}
