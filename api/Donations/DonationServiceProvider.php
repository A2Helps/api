<?php

namespace Api\Donations;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Donations\Services\DonationService;

class DonationServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = DonationService::class;
}
