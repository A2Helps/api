<?php

namespace Admin\Merchants;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Admin\Merchants\Services\AdminMerchantService;

class MerchantServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminMerchantService::class;
}
