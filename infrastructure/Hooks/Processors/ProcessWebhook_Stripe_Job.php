<?php

namespace Infrastructure\Hooks\Processors;

use Api\Donations\DonationFacade;
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
				$lc->info('checkout session was completed', ['co_session' => $id]);
				DonationFacade::donationCompleted($id);
				break;

			case 'charge.captured':
			case 'charge.expired':
			case 'charge.failed':
			case 'charge.pending':
			case 'charge.refunded':
			case 'charge.succeeded':
			case 'charge.updated':
			case 'charge.dispute.closed':
			case 'charge.dispute.created':
			case 'charge.dispute.funds_reinstated':
			case 'charge.dispute.funds_withdrawn':
			case 'charge.dispute.updated':
			case 'charge.refund.updated':
				$lc->info('received stripe event', ['charge' => $event->data->object->id]);
				break;

			case 'payment_intent.amount_capturable_updated':
			case 'payment_intent.canceled':
			case 'payment_intent.created':
			case 'payment_intent.payment_failed':
			case 'payment_intent.processing':
			case 'payment_intent.succeeded':
				$lc->info('received stripe event', ['payment_intent' => $event->data->object->id]);
				break;

			default:
				$lc->warning('unhandled event type');
		}
	}
}
