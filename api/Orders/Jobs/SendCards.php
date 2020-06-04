<?php

namespace Api\Orders\Jobs;

use Api\Orders\Mailables\Cards;
use Api\Orders\Mailers\Confirmation;
use Api\Orders\Mailers\WireInstructions;
use Api\Orders\Models\Order;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Facades\Mail;
use Infrastructure\Jobs\QueuedJob;

class SendCards extends QueuedJob
{
	protected $order;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$lc = new LogContext(['order_id' => $this->order->id]);

		if ($this->order->cards_sent) {
			$lc->warning('order cards already sent');
			return;
		}

		if (empty($this->order->recipient->email)) {
			$lc->info('no order email associated');

			return;
		}

		$mailable = new Cards(
			$this->order,
		);

		Mail::send($mailable);

		$this->order->cards_sent = true;
		$this->order->cards_sent_at = now();
		$this->order->save();
	}
}
