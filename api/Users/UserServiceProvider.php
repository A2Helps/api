<?php

namespace Api\Users;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Users\Services\UserService;

class UserServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = UserService::class;
}
