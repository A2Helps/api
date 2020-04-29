<?php

namespace Api\OrderCards;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\OrderCards\Services\OrderCardService;

class OrderCardServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = OrderCardService::class;
}
