<?php

namespace Api\Orders;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Orders\Services\OrderService;

class OrderServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = OrderService::class;
}
