<?php

namespace Api\Cards;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Cards\Services\CardService;

class CardServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = CardService::class;
}
