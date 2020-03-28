<?php

namespace Infrastructure\Stripe;

use Api\Donations\Models\Donation;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;

class StripeService
{
	public function createCheckout(Donation $donation): Session
	{
		$session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'billing_address_collection' => 'required',
			'submit_type' => 'donate',

			'line_items' => [
				[
					'name' => 'Donation',
					'description' => 'A2 Helps Donation',
					'images' => ['https://example.com/donation.png'],
					'amount' => $donation->amount,
					'currency' => 'usd',
					'quantity' => 1
				]
			],

			'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
			'cancel_url' => 'https://example.com/cancel?session_id={CHECKOUT_SESSION_ID}',
		  ]);

		Log::info('created stripe checkout session', ['session_id' => $session->id]);

		return $session;
	}
}
