<?php

namespace Api\Orders\Mailables;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Api\Orders\Models\Order;
use Illuminate\Support\Facades\Log;

class Cards extends Mailable
{
	use SerializesModels;

	public $order;

	public $data;

	/**
	 * The urls.
	 *
	 * @var string
	 */
	public $urls;

	public $subject = 'Your cards have arrived! | A2 Helps';

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;

		$this->data = $order->orderCards->map(function($oc) {
			return [
				'merchant' => $oc->merchant->name,
				'amount'   => round(money_human($oc->card->amount)),
				'number'   => $oc->card->number,
			];
		});
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		Log::debug('built cards');

		return $this->view('mail.cards.html')
			->text('mail.cards.text')
			->from(
				'cards@e.a2helps.com',
				'A2 Helps'
			)
			->to($this->order->recipient->email)
			->subject($this->subject);
	}
}
