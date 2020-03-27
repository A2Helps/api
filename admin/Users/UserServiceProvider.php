<?php

namespace Admin\Users;

use Admin\Users\Services\AdminUserService;
use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;

class UserServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminUserService::class;
}
