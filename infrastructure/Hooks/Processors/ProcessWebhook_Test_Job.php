<?php

namespace Infrastructure\Hooks\Processors;

use \Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessHook_Test_Job extends SpatieProcessWebhookJob
{
	public function handle()
	{
		\Log::warning('processing WH');

		// $this->webhookCall // contains an instance of `WebhookCall`

		// perform the work here
	}
}
