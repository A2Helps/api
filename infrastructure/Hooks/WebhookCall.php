<?php

namespace Infrastructure\Hooks;

use Spatie\WebhookClient\Models\WebhookCall as ModelsWebhookCall;

class WebhookCall extends ModelsWebhookCall
{
	protected $keyType = 'string';
}
