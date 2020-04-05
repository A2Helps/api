<?php

namespace Api\Donations;

use Infrastructure\Events\EventProvider;

class DonationEventProvider extends EventProvider
{
	protected $listen = [
		Events\Completed::class => [
			Listeners\SendConfirmation::class
		],

		// Events\WireCreated::class => [

		// ],
	];
}
