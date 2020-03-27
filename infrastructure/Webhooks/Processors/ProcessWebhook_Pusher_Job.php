<?php

namespace Infrastructure\Webhooks\Processors;

use Illuminate\Support\Facades\Log;
use \Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhook_Pusher_Job extends SpatieProcessWebhookJob
{
	public function handle()
	{
		foreach ($this->webhookCall->payload['events'] as $event) {
			Log::info('Processing pusher webhook', ['event' => $event['name'], 'chan' => $event['channel']]);

			// channel_vacated
			// channel_occupied
		}
	}
}
