<?php

namespace Api\Donations\Events;

use Infrastructure\Events\Event;
use Api\Donations\Models\Donation;

class Completed extends Event
{
	public $donation;

	public function __construct(Donation $donation)
	{
		$this->donation = $donation;
	}
}
