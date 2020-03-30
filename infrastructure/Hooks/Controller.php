<?php

namespace Infrastructure\Hooks;

use Infrastructure\Hooks\WebhookCall;
use Illuminate\Http\Request;
use Infrastructure\Http\Controller as BaseController;
use Infrastructure\Hooks\Processors\ProcessHook_Pusher_Job;
use Infrastructure\Hooks\Processors\ProcessHook_Stripe_Job;
use Infrastructure\Hooks\Processors\ProcessHook_Test_Job;
use Infrastructure\Hooks\SignatureValidators\TestSignatureValidator;
use Infrastructure\Hooks\SignatureValidators\StripeSignatureValidator;
use Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator;
use Spatie\WebhookClient\WebhookProcessor;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;

class Controller extends BaseController
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
			'process_webhook_job'   => ProcessHook_Test_Job::class,
		]);

		(new WebhookProcessor($request, $webhookConfig))->process();
	}

	public function receive_pusher(Request $request)
	{
		$webhookConfig = new \Spatie\WebhookClient\WebhookConfig([
			'name'                  => 'pusher',
			'signing_secret'        => config('hooks.pusher.signing-key'),
			'signature_header_name' => 'X-Pusher-Signature',
			'signature_validator'   => DefaultSignatureValidator::class,
			'webhook_profile'       => ProcessEverythingWebhookProfile::class,
			'webhook_model'         => WebhookCall::class,
			'process_webhook_job'   => ProcessHook_Pusher_Job::class,
		]);

		(new WebhookProcessor($request, $webhookConfig))->process();
	}

	public function receive_stripe(Request $request)
	{
		$webhookConfig = new \Spatie\WebhookClient\WebhookConfig([
			'name'                  => 'pusher',
			'signing_secret'        => config('hooks.stripe.signing-key'),
			'signature_header_name' => 'Stripe-Signature',
			'signature_validator'   => StripeSignatureValidator::class,
			'webhook_profile'       => ProcessEverythingWebhookProfile::class,
			'webhook_model'         => WebhookCall::class,
			'process_webhook_job'   => ProcessHook_Stripe_Job::class,
		]);

		(new WebhookProcessor($request, $webhookConfig))->process();
	}

}
