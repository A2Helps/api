<?php

namespace Infrastructure\Stripe;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Infrastructure\Stripe\StripeService;
use Stripe\Stripe;

class StripeServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = StripeService::class;

	public function register()
	{
		Stripe::setApiKey(config('stripe.secret'));

		parent::register();
	}
}
