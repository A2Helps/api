<?php

namespace Admin\Givers;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Admin\Givers\Services\AdminGiverService;

class GiverServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminGiverService::class;
}
