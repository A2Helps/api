<?php

namespace Infrastructure\Hooks\SignatureValidators;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class TestSignatureValidator extends DefaultSignatureValidator
{
	public function isValid(Request $request, WebhookConfig $config): bool
	{
		// MAILGUN


		$signature = $request->get('signature');

		if (! is_array($signature) || !Arr::has($signature, ['signature', 'token', 'timestamp'])) {
			return false;
		}

		$signingSecret = $config->signingSecret;

		if (empty($signingSecret)) {
			throw WebhookFailed::signingSecretNotSet();
		}

		$data = $signature['timestamp'] . $signature['token'];
		$computedSignature = hash_hmac('sha256', $data, $signingSecret);

		return hash_equals($signature['signature'], $computedSignature);
	}
}
