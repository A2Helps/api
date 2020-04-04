<?php

namespace Api\Merchants;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Merchants\Services\MerchantService;

class MerchantServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = MerchantService::class;
}
