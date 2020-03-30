<?php

return [

	'pusher' => [
		'signing-key' => env('PUSHER_APP_SECRET'),
	],

	'stripe' => [
		'signing-key' => env('STRIPE_SIGNING_SECRET'),
	],

];
