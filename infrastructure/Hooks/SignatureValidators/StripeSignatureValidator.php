<?php

namespace Infrastructure\Hooks\SignatureValidators;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class StripeSignatureValidator extends DefaultSignatureValidator
{
	public function isValid(Request $request, WebhookConfig $config): bool
	{
		$signature = $request->header($config->signatureHeaderName);

		if (!$signature) {
			Log::info('stripe hook signature missing');
			return false;
		}

		$payload = $request->getContent();
		$secret = $config->signingSecret;

		if (!$secret) {
			Log::info('stripe hook signing secret not set');
			throw WebhookFailed::signingSecretNotSet();
		}

		try {
			\Stripe\Webhook::constructEvent(
				$payload, $signature, $secret
			);
		}
		catch(\UnexpectedValueException $e) {
			Log::info('invalid stripe hook payload');

			return false;
		}
		catch(\Stripe\Exception\SignatureVerificationException $e) {
			Log::info('invalid stripe hook signature');

			return false;
		}

		Log::debug('stripe hook signature vaidation passed');
		return true;
	}
}
