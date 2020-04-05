<?php

namespace Api\Donations\Listeners;

use Api\Donations\Events\Completed as Event;
use Api\Donations\Jobs\SendConfirmationJob;
use Illuminate\Support\Facades\Log;

class SendConfirmation {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  Event  $event
	 * @return void
	 */
	public function handle(Event $event)
	{
		Log::info('Dispatching Job', ['name' => 'SendConfirmationJob']);
		dispatch(new SendConfirmationJob($event->donation));
	}
}
