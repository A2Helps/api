<?php

namespace Api\Givers;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Givers\Services\GiverService;

class GiverServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = GiverService::class;
}
