<?php

namespace Infrastructure\Webhooks\Controllers;

use Api\WebhookCalls\Models\WebhookCall;
use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Infrastructure\Webhooks\Processors\ProcessWebhook_Pusher_Job;
use Infrastructure\Webhooks\Processors\ProcessWebhook_Test_Job;
use Infrastructure\Webhooks\SignatureValidators\TestSignatureValidator;
use Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator;
use Spatie\WebhookClient\WebhookProcessor;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;

class WebhookController extends BaseController
{
	public function receive_test(Request $request)
	{
		// mailgun
		$webhookConfig = new \Spatie\WebhookClient\WebhookConfig([
			'name'                  => 'test',
			'signing_secret'        => '032f43a56747589664518e28c61b8309',
			// 'signature_header_name' => 'Signature',
			// 'signature_validator'   => DefaultSignatureValidator::class,
			'signature_validator'   => TestSignatureValidator::class,
			'webhook_profile'       => ProcessEverythingWebhookProfile::class,
			'webhook_model'         => WebhookCall::class,
			'process_webhook_job'   => ProcessWebhook_Test_Job::class,
		]);

		(new WebhookProcessor($request, $webhookConfig))->process();
	}

	public function receive_pusher(Request $request)
	{
		$webhookConfig = new \Spatie\WebhookClient\WebhookConfig([
			'name'                  => 'pusher',
			'signing_secret'        => config('broadcasting.connections.pusher.secret'),
			'signature_header_name' => 'X-Pusher-Signature',
			'signature_validator'   => DefaultSignatureValidator::class,
			'webhook_profile'       => ProcessEverythingWebhookProfile::class,
			'webhook_model'         => WebhookCall::class,
			'process_webhook_job'   => ProcessWebhook_Pusher_Job::class,
		]);

		(new WebhookProcessor($request, $webhookConfig))->process();
	}
}
