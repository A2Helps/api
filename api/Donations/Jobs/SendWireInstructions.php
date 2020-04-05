<?php

namespace Api\Donations\Jobs;

use Api\Donations\Mailers\Confirmation;
use Api\Donations\Mailers\WireInstructions;
use Api\Donations\Models\Donation;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Facades\Mail;
use Infrastructure\Jobs\QueuedJob;

class SendWireInstructions extends QueuedJob
{
	protected $donation;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Donation $donation)
	{
		$this->donation = $donation;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$lc = new LogContext(['donation_id' => $this->donation->id]);

		if (! $this->donation->wired) {
			$lc->warning('donation was not wired, not sending wire instructions');
			return;
		}

		$lc->info('sending donation wire instructions');

		if (empty($this->donation->email)) {
			$lc->info('no donation email associated');

			return;
		}

		$mailable = new WireInstructions(
			$this->donation,
		);

		Mail::send($mailable);
	}
}
