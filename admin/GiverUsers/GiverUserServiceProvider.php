<?php

namespace Admin\GiverUsers;

use Admin\GiverUsers\Services\AdminGiverUserService;
use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;

class GiverUserServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminGiverUserService::class;
}
