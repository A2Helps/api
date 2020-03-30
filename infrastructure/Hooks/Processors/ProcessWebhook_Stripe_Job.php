<?php

namespace Infrastructure\Hooks\Processors;

use Cumulati\Monolog\LogContext;
use Illuminate\Support\Facades\Log;
use \Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessHook_Stripe_Job extends SpatieProcessWebhookJob
{
	public function handle()
	{
		$lc = new LogContext(['webhook_call_id' => $this->webhookCall->id, 'type' => 'stripe']);
		$lc->debug('processing webhook');

		try {
			$event = \Stripe\Event::constructFrom($this->webhookCall->payload);
		} catch(\UnexpectedValueException $e) {
			Log::error('cannot process webhook. failed constructing stripe event from payload');
			throw $e;
		}

		$lc->addContext(['event' => $event->type]);
		$lc->info('processing webhook');

		// Handle the event
		switch ($event->type) {
			case 'checkout.session.completed':
				$id = $event->data->object->id;
				$lc->info('check session was completed', ['co_session' => $id]);
				break;

			default:
				$lc->warning('unhandled event type');
		}
	}
}
