<?php

namespace Infrastructure\Webhooks\Processors;

use \Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhook_Test_Job extends SpatieProcessWebhookJob
{
	public function handle()
	{
		\Log::warning('processing WH');

		// $this->webhookCall // contains an instance of `WebhookCall`

		// perform the work here
	}
}
